<x-layout>
   <x-breadcrums class="mb-4"
   :links="['jobs' => route('jobs.index'), $job->title => '#']"/>
   <x-job-card :$job>
    <p class="mb-4 text-sm text-slate-500">{{ $job->description }}</p>
   </x-job-card>
</x-layout>
