<x-mail::message>
# Notification
<h2>
    {{$job->title}}
</h2>
<p>
    Congrats! your job is now live on the website.
</p>

<p>
    <a href="{{ url('/jobs/'. $job->id) }}">Click here to see your job.</a>
</p>

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
