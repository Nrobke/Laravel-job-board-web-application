<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Mail\JobPosted;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAnyEmployer', Job::class);

        return view(
            'my_job.index',
            [
                'jobs' => auth()->user()->employer
                    ->jobs()
                    ->with(['employer', 'jobApplications', 'jobApplications.user'])
                    ->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Job::class);

        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        Gate::authorize('create', Job::class);

        $job = auth()->user()->employer->jobs()
                ->create($request->validated());

        Mail::to(auth()->user())->queue(
            new JobPosted($job)
        );

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job created successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        Gate::authorize('update', $myJob);

        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $myJob)
    {
        Gate::authorize('update', $myJob);

        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $myJob)
    {
        try
        {
            $myJob->delete();
            return redirect()->route('my-jobs.index')
                ->with('success', 'Job Deleted successfully.');

        } catch(Exception $e){

            $errorMessage = $e->getMessage();

            if (str_contains($errorMessage, 'SQLSTATE')) {
                $errorMessage = 'Database error occurred while deleting the job.';
            } else {
                // You can define other custom messages based on specific keywords
                $errorMessage = 'An error occurred while deleting the job.';
            }

            return redirect()->route('my-jobs.index')
                ->with('error', $errorMessage);
        }

    }
}
