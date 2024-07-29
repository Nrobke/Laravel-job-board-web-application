<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Job::class);

        $filters = $request->only(
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        );

        return view('job.index', ['jobs' => job::with('employer')->latest()->filter($filters)->get()]);
    }


    public function show(Job $job)
    {
        Gate::authorize('view', Job::class);

        return view('job.show', ['job' => $job->load('employer.jobs')]);
    }
}
