<x-layout>
   <x-breadcrums class="mb-4"
   :links="['jobs' => route('jobs.index'), $job->title => '#']"/>
   <x-job-card :$job>
    <p class="mb-4 text-sm text-slate-500">{{ $job->description }}</p>

    @can('apply', $job)
        <x-link-button :href="route('job.application.create', $job)">
            Apply
        </x-link-button>
    @else
        @if (auth()->user())
            <div class="text-center text-sm font-medium text-slate-500">
                You already applied to this job
            </div>
        @else
            <div class="text-center text-sm font-medium text-slate-500">
                you need to log in to apply for this job
            </div>
        @endif
    @endcan

   </x-job-card>
   <x-card class="mb-4">
    <h2 class="mb-4 text-lg font-medium">Other Jobs by {{ $job->employer->company_name }}</h2>
    <div class="text-sm text-slate-500">
        @foreach ($job->employer->jobs as $anotherOne)
            <div class="mb-4 flex justify-between">
                <div>
                    <div class="text-slate-700">
                        <a href="{{ route('jobs.show', ['job' => $anotherOne])}}">{{ $anotherOne->title }}</a>
                    </div>
                    <div class="text-xs">
                        {{ $anotherOne->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="text-xs">
                    ${{ number_format($anotherOne->salary) }}
                </div>
            </div>
        @endforeach
    </div>
   </x-card>
</x-layout>
