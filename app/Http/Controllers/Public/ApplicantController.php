<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicantOtpMail;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    // Step 1: Show Email Entry Form
    public function showEmailForm($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        
        if ($career->is_closed) {
            return redirect()->route('careers.detail', $slug)->with('error', 'This vacancy is closed.');
        }

        return view('careers.apply-step1-email', compact('career'));
    }

    // Step 1 Action: Generate and Send OTP
    public function sendOtp(Request $request, $slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();

        if ($career->is_closed) {
            return redirect()->route('careers.detail', $slug)->with('error', 'This vacancy is closed.');
        }

        $request->validate([
            'email' => 'required|email:rfc,dns|max:255',
        ]);

        $otp = strtoupper(Str::random(6)); // Generate a 6-character alphanumeric OTP

        // Store OTP and email in session (valid for 15 minutes roughly if session persists, but we'll trust standard session lifetime here)
        session([
            'apply_email' => $request->email,
            'apply_otp' => $otp,
            'apply_slug' => $slug
        ]);

        // Send Email using the dedicated recruitment mailer
        Mail::mailer('recruitment')
            ->to($request->email)
            ->send(new ApplicantOtpMail($otp, $career->title));

        return redirect()->route('careers.apply.otp', $slug)->with('success', 'Verification code sent to your email.');
    }

    // Step 2: Show OTP Verification Form
    public function showOtpForm($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        
        // Ensure they came from step 1 for this specific job
        if (session('apply_slug') !== $slug || !session('apply_email')) {
            return redirect()->route('careers.apply.email', $slug)->with('error', 'Please enter your email first.');
        }

        return view('careers.apply-step2-otp', compact('career'));
    }

    // Step 2 Action: Verify OTP
    public function verifyOtp(Request $request, $slug)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        if (strtoupper($request->otp) === session('apply_otp')) {
            // OTP is correct, set a verified flag
            session(['apply_verified' => true]);
            
            // Clear the actual OTP so it can't be reused, but keep the email for the final form
            $request->session()->forget('apply_otp');

            return redirect()->route('careers.apply', $slug)->with('success', 'Email verified successfully.');
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid verification code. Please try again.']);
    }

    // Step 3: Show Final Application Form
    public function showApplyForm($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        
        if ($career->is_closed) {
            return redirect()->route('careers.detail', $slug)->with('error', 'This vacancy is closed.');
        }

        // Ensure email is verified
        if (!session('apply_verified') || session('apply_slug') !== $slug) {
            return redirect()->route('careers.apply.email', $slug)->with('error', 'Please verify your email address first.');
        }

        return view('careers.apply', compact('career'));
    }

    // Step 3 Action: Store Application
    public function store(Request $request, $slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();

        if ($career->is_closed) {
            return redirect()->route('careers.detail', $slug)->with('error', 'This vacancy is closed.');
        }

        // Double check verified status
        if (!session('apply_verified') || session('apply_slug') !== $slug) {
            return redirect()->route('careers.apply.email', $slug)->with('error', 'Session expired. Please verify your email again.');
        }

        $request->validate([
            // Contact Information
            'title' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'phone_code' => 'required',
            'phone_number' => 'required|numeric',
            'linkedin_profile' => 'nullable|url',
            'resume' => 'required|file|mimes:pdf|max:2048',
            'portfolio' => 'nullable|file|mimes:pdf|max:5120',

            // Addresses (Dynamic Array)
            'addresses' => 'required|array|min:1',
            'addresses.*.country' => 'required|string|max:255',
            'addresses.*.postal_code' => 'required|string|max:10',
            'addresses.*.address_line' => 'required|string',
            'addresses.*.city_regency' => 'required|string|max:255',
            'addresses.*.province' => 'required|string|max:255',

            // Education (Dynamic Array)
            'educations' => 'required|array|min:1',
            'educations.*.degree' => 'required|string',
            'educations.*.major' => 'required|string|max:255',
            'educations.*.school' => 'required|string|max:255',
            'educations.*.start_date' => 'required|date',
            'educations.*.end_date' => 'required|date|after_or_equal:educations.*.start_date',
            'educations.*.country' => 'required|string|max:255',

            // Experience (Dynamic Array)
            'experiences' => 'nullable|array',
            'experiences.*.job_title' => 'required|string|max:255',
            'experiences.*.company' => 'required|string|max:255',
            'experiences.*.city' => 'nullable|string|max:255',
            'experiences.*.type_business' => 'nullable|string|max:255',
            'experiences.*.start_date' => 'required|date',
            'experiences.*.end_date' => 'nullable|date|after_or_equal:experiences.*.start_date',
            'experiences.*.job_desc' => 'nullable|string',

            // Certification (Dynamic Array)
            'certifications' => 'nullable|array',
            'certifications.*.name' => 'required|string|max:255',
            'certifications.*.issued_by' => 'required|string|max:255',
            'certifications.*.issued_date' => 'required|date',
            'certifications.*.expiration_date' => 'nullable|date|after_or_equal:certifications.*.issued_date',

            // Final Details (Step 6)
            'cover_letter' => 'nullable|string|max:5000',
            'confirm_data' => 'required|accepted',
        ], [
            'resume.mimes' => 'Resume must be a PDF file.',
            'portfolio.mimes' => 'Portfolio must be a PDF file.',
            'confirm_data.required' => 'You must confirm that all data is correct.'
        ]);

        $resumePath = $request->file('resume')->store('applicants/resumes', 'public');
        
        $portfolioPath = null;
        if ($request->hasFile('portfolio')) {
            $portfolioPath = $request->file('portfolio')->store('applicants/portfolios', 'public');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            // Construct full name
            $fullName = trim($request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name);
            
            $applicant = Applicant::create([
                'career_id' => $career->id,
                'name' => $fullName,
                'email' => session('apply_email'),
                'phone' => $request->phone_code . $request->phone_number,
                'resume_path' => $resumePath,
                'portfolio_path' => $portfolioPath,
                'cover_letter' => $request->cover_letter,
                
                'title' => $request->title,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'linkedin_profile' => $request->linkedin_profile,
                
                'status' => 'pending', 
            ]);

            // Save Addresses
            if ($request->has('addresses')) {
                foreach ($request->addresses as $addr) {
                    $applicant->addresses()->create($addr);
                }
            }

            // Save Educations
            if ($request->has('educations')) {
                foreach ($request->educations as $edu) {
                    $applicant->educations()->create($edu);
                }
            }

            // Save Experiences
            if ($request->has('experiences')) {
                foreach ($request->experiences as $exp) {
                    $applicant->experiences()->create($exp);
                }
            }
            
            // Save Certifications
            if ($request->has('certifications')) {
                foreach ($request->certifications as $cert) {
                    $applicant->certifications()->create($cert);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            
            // Delete uploaded files to avoid storage bloat on failure
            Storage::disk('public')->delete($resumePath);
            if ($portfolioPath) {
                Storage::disk('public')->delete($portfolioPath);
            }
            
            \Illuminate\Support\Facades\Log::error("Failed to store applicant application: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving your application. Please try again.')->withInput();
        }

        // Refresh and load relationship for the email
        $applicant->load('career', 'addresses', 'educations', 'experiences', 'certifications');

        // Send Initial Email Notification to Applicant
        try {
            Mail::mailer('recruitment')
                ->to($applicant->email)
                ->send(new \App\Mail\ApplicantStatusMail($applicant));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send welcome email to applicant: " . $e->getMessage());
        }

        // Clean up session after successful application
        $request->session()->forget(['apply_email', 'apply_otp', 'apply_slug', 'apply_verified']);

        return redirect()->route('careers.detail', $slug)->with('success', 'Applied Successfully!');
    }
}
