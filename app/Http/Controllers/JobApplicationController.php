<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobApplicationController extends Controller
{

    public function create(Request $request, Job $job)
    {
        Gate::authorize('apply', $job);
        // if ($request->user()->cannot('apply', $job)) {
        //     abort(403);
        // }
        return view('job_application.create', ['job' => $job]);
    }

    public function store(Job $job, Request $request)
    {
        $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            ...$request->validate([
                'expected_salary' => 'required|min:1|max:1000000'
            ])
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Application submitted successfully.');
    }


    public function destroy(string $id)
    {
        //
    }
}