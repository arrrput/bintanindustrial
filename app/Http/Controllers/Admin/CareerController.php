<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Applicant;
use App\Models\SectionSetting;
use Illuminate\Http\Request;
use App\Services\LinkedInService;
use App\Helpers\LogHelper;
use Illuminate\Support\Str;

class CareerController extends Controller
{
    public function index()
    {
        Applicant::autoRejectClosedVacancyApplicants();

        $allCareers = Career::withCount([
            'applicants',
            'applicants as hired_count' => function ($query) {
                $query->where('status', 'hired');
            }
        ])->orderBy('created_at', 'desc')->get();
        
        // Separate based on is_closed attribute
        $activeCareers = $allCareers->filter(fn($c) => !$c->is_closed);
        $historyCareers = $allCareers->filter(fn($c) => $c->is_closed)
            ->sortByDesc('created_at')
            ->groupBy(function($career) {
                return \Carbon\Carbon::parse($career->created_at)->format('F Y');
            });

        $latestApplicants = Applicant::with('career')
            ->whereNotIn('status', ['hired', 'rejected'])
            ->latest()
            ->take(3)
            ->get();
        $setting = SectionSetting::where('section_key', 'career')->first();
        return view('cms.careers.index', compact('activeCareers', 'historyCareers', 'latestApplicants', 'setting')); 
    }

    // Menampilkan form tambah lowongan
    public function create()
    {
        return view('cms.careers.create'); // <-- Mengarah ke admin/careers/create
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'level' => 'required',
            'min_education' => 'required',
            'min_experience' => 'required',
            'description' => 'required',
            'requirements' => 'required',
            'closing_date' => 'required|date', 
            'linkedin_caption' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi|max:10240', // Max 10MB
        ]);

        $data = $request->all();
        $data['slug'] = $this->generateUniqueSlug($request->title);
        $data['posted_date'] = \Carbon\Carbon::today()->toDateString(); 
        $data['post_to_linkedin'] = $request->has('post_to_linkedin');

        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('careers', 'public');
        }

        $career = Career::create($data);

        LogHelper::log('CREATE', 'Careers', "Published new job vacancy: {$career->title}");

        // LinkedIn Automation
        if ($career->post_to_linkedin) {
            $caption = $request->linkedin_caption ?? $this->generateDefaultLinkedinCaption($career);
            
            // Simpan caption yang digunakan
            $career->update(['linkedin_caption' => $caption]);

            $mediaPath = $career->media ? storage_path('app/public/' . $career->media) : null;
            
            $linkedinService = new LinkedInService();
            $linkedinPostId = $linkedinService->publishPost($caption, $mediaPath);

            if ($linkedinPostId) {
                $career->update(['linkedin_post_id' => $linkedinPostId]);
            }
        }

        return redirect()->route('cms.careers.index')->with('success', 'Job vacancy successfully published!');
    }

    public function update(Request $request, Career $career)
    {
        $request->validate([
            'title' => 'required',
            'level' => 'required',
            'min_education' => 'required',
            'min_experience' => 'required',
            'description' => 'required',
            'requirements' => 'required',
            'closing_date' => 'required|date',
            'linkedin_caption' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi|max:10240',
        ]);

        $data = $request->all();
        // Update slug only if title changes
        if ($career->title !== $request->title) {
            $data['slug'] = $this->generateUniqueSlug($request->title, $career->id);
        }
        $data['post_to_linkedin'] = $request->has('post_to_linkedin');

        if ($request->hasFile('media')) {
            // Hapus media lama jika ada
            if ($career->media && \Storage::disk('public')->exists($career->media)) {
                \Storage::disk('public')->delete($career->media);
            }
            $data['media'] = $request->file('media')->store('careers', 'public');
        }

        // LinkedIn Automation (Hanya jika dicentang saat update)
        if ($request->has('post_to_linkedin')) {
            // Jika user mengisi caption baru di form, gunakan itu. 
            // Jika kosong tapi ingin auto-post, generate baru atau gunakan yang lama? 
            // Sesuai permintaan: gunakan yang ada di form (yang mungkin sudah terisi caption lama).
            $caption = $request->linkedin_caption ?? $this->generateDefaultLinkedinCaption($career);
            
            $data['linkedin_caption'] = $caption;

            // Gunakan media baru jika diupload, jika tidak gunakan yang lama
            $currentMedia = isset($data['media']) ? $data['media'] : $career->media;
            $mediaPath = $currentMedia ? storage_path('app/public/' . $currentMedia) : null;
            
            $linkedinService = new LinkedInService();
            $linkedinPostId = $linkedinService->publishPost($caption, $mediaPath);

            if ($linkedinPostId) {
                $data['linkedin_post_id'] = $linkedinPostId;
            }
        }

        // Saat update, kita tidak mengubah posted_date (biarkan tanggal aslinya)
        $career->update($data);

        LogHelper::log('UPDATE', 'Careers', "Updated job vacancy: {$career->title}");

        return redirect()->route('cms.careers.index')->with('success', 'Job vacancy successfully updated!');
    }

    /**
     * Generate a unique slug for the career
     */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Career::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Generate default professional caption for LinkedIn
     */
    private function generateDefaultLinkedinCaption($career)
    {
        $closingDate = \Carbon\Carbon::parse($career->closing_date)->format('d F Y');
        $jobUrl = route('careers.detail', $career->slug); 

        return "📢 WE ARE HIRING!\n\n" .
               "Bintan Industrial Estate is looking for a talented " . strtoupper($career->title) . " to join our growing team.\n\n" .
               "📍 Location: " . $career->location . "\n" .
               "💼 Level: " . $career->level . "\n" .
               "🎓 Min. Education: " . $career->min_education . "\n" .
               "⏳ Experience: " . $career->min_experience . "\n" .
               "📅 Closing Date: " . $closingDate . "\n\n" .
               "If you are passionate and meet the requirements, we'd love to hear from you!\n\n" .
               "Apply now at:\n" .
               "🔗 " . $jobUrl . "\n\n" .
               "#Hiring #BIIE #BintanIndustrialEstate #JobVacancy #CareerBintan #LokerBintan #LokerRiau #LokerKepri #Recruitment #" . str_replace(' ', '', $career->title);
    }

    // Menampilkan form edit lowongan berdasarkan ID
    public function edit(Career $career)
    {
        return view('cms.careers.edit', compact('career')); // <-- Mengarah ke admin/careers/edit
    }

    // Menghapus lowongan atau memindahkannya ke history
    public function destroy(Career $career)
    {
        $title = $career->title;

        if (!$career->is_closed) {
            // Move to history (soft close)
            $career->update(['status' => 'closed']);
            LogHelper::log('UPDATE', 'Careers', "Closed job vacancy (moved to history): {$title}");
            return redirect()->route('cms.careers.index')->with('success', 'Job vacancy successfully closed and moved to history.');
        }

        // Hard delete if already closed
        $career->delete();
        LogHelper::log('DELETE', 'Careers', "Deleted job vacancy permanently: {$title}");

        return redirect()->route('cms.careers.index')->with('success', 'Job vacancy permanently deleted!');
    }
}