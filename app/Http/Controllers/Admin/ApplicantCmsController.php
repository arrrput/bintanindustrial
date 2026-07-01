<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Career;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class ApplicantCmsController extends Controller
{
    public function index()
    {
        Applicant::autoRejectClosedVacancyApplicants();

        $request = request();
        $baseQuery = Applicant::with('career');

        if ($request->filled('career_id')) {
            $baseQuery->where('career_id', $request->career_id);
        }

        $activeApplicants = (clone $baseQuery)
            ->whereNotIn('status', ['hired', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->paginate(20, ['*'], 'active_page');

        $historyApplicants = (clone $baseQuery)
            ->whereIn('status', ['hired', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20, ['*'], 'history_page');

        $careers = Career::all();

        return view('cms.applicants.index', compact('activeApplicants', 'historyApplicants', 'careers'));
    }

    public function show(Applicant $applicant)
    {
        return view('cms.applicants.show', compact('applicant'));
    }

    public function updateStatus(Request $request, Applicant $applicant)
    {
        $request->validate([
            'status' => 'required|in:pending,screening,interview,rejected,hired',
            'status_reason' => 'nullable|string'
        ]);

        $oldStatus = $applicant->status;
        $applicant->update([
            'status' => $request->status,
            'status_reason' => $request->status_reason ?? $applicant->status_reason
        ]);

        // Send Status Update Email Notification
        \Illuminate\Support\Facades\Mail::mailer('recruitment')
            ->to($applicant->email)
            ->send(new \App\Mail\ApplicantStatusMail($applicant));

        $reasonLog = $request->status_reason ? " (Reason: {$request->status_reason})" : '';
        LogHelper::log('UPDATE', 'Applicants', "Updated applicant status: {$applicant->name} for {$applicant->career->title} ({$oldStatus} -> {$request->status}){$reasonLog}");

        return back()->with('success', 'Applicant status updated successfully.');
    }

    public function destroy(Applicant $applicant)
    {
        $name = $applicant->name;
        $job = $applicant->career->title;
        
        $applicant->delete();

        LogHelper::log('DELETE', 'Applicants', "Deleted applicant: $name for $job");

        return redirect()->route('cms.applicants.index')->with('success', 'Applicant deleted successfully.');
    }
}
