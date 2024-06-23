@component('mail::message')
# Group Swim Lesson Progress Report

Hey {{ $swimmer->firstName }}, congratulations on completing your {{$lesson->group->type}} swim lessons.<br>

@if ($graduated)
You can find your progress report below. It looks like you mastered all the skills for the {{$lesson->group->type}}.
We have attached your certificate to this email. Keep up the good work and we hope to see you in the next level soon.
@else
You can find your progress report below. It looks like you still need to work on some skills before you can graduate to the next level.<br>
@endif

{{-- List out all the skills_passed that the swimmer learned in the lesson --}}
@if ($skills_passed->count() > 0)
@component('mail::panel')
## Skills you mastered
@foreach ($skills_passed as $index => $progressReport)
✔ {{ $progressReport->skill->description }}<br>
@endforeach
@endcomponent
@endif

{{-- List out all the skills_failed that the swimmer learned in the lesson --}}
@if ($skills_failed->count() > 0)
@component('mail::panel')
## Skills that still need work
@foreach ($skills_failed as $progressReport)
✗ {{ $progressReport->skill->description }}<br>
@endforeach
@endcomponent
@endif

Thanks,<br>
The Swim School
@endcomponent
