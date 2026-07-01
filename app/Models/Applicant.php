<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id', 'name', 'email', 'phone', 'resume_path', 'portfolio_path', 'cover_letter', 'status', 'status_reason',
        'title', 'first_name', 'last_name', 'middle_name', 'linkedin_profile'
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected static function booted()
    {
        static::deleting(function ($applicant) {
            if ($applicant->resume_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($applicant->resume_path);
            }
            if ($applicant->portfolio_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($applicant->portfolio_path);
            }
        });
    }

    public static function autoRejectClosedVacancyApplicants()
    {
        // Find closed careers
        $closedCareerIds = Career::where('status', 'closed')
            ->orWhere('closing_date', '<', \Carbon\Carbon::today()->toDateString())
            ->pluck('id');
            
        if ($closedCareerIds->isEmpty()) {
            return;
        }

        // Get unprocessed applicants for these careers
        $unprocessedApplicants = self::whereIn('career_id', $closedCareerIds)
            ->whereNotIn('status', ['hired', 'rejected'])
            ->with('career')
            ->get();

        foreach ($unprocessedApplicants as $applicant) {
            $applicant->update([
                'status' => 'rejected',
                'status_reason' => 'Automatically rejected because the job vacancy has reached its closing date.'
            ]);

            try {
                // Send Status Update Email Notification
                \Illuminate\Support\Facades\Mail::mailer('recruitment')
                    ->to($applicant->email)
                    ->send(new \App\Mail\ApplicantStatusMail($applicant));
            } catch (\Exception $e) {
                // Log email failure so the application flow doesn't break
                \Log::error("Failed to send auto-reject email to {$applicant->email}: " . $e->getMessage());
            }
        }
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function addresses()
    {
        return $this->hasMany(ApplicantAddress::class);
    }

    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(ApplicantExperience::class);
    }

    public function certifications()
    {
        return $this->hasMany(ApplicantCertification::class);
    }

    public function getEduDegreeAttribute()
    {
        $latestEdu = $this->educations()->latest('end_date')->first();
        return $latestEdu ? $latestEdu->degree : '-';
    }

    public function getEduMajorAttribute()
    {
        $latestEdu = $this->educations()->latest('end_date')->first();
        return $latestEdu ? $latestEdu->major : '-';
    }
}
