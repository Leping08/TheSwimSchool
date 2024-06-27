@component('mail::message')
# The Swim School Group Lesson Report Card

@if ($graduated)
Congratulations, {{ $swimmer->firstName }}!  You've completed the {{$lesson->group->type}} swim course!<br>

Below is your Report Card for this session. You've mastered all the skills required to graduate to the next level!
@else
Hi, {{ $swimmer->firstName }}! Thanks for swimming with us in the {{$lesson->group->type}} swim course!<br>

Below is your Report Card for this session. You've been able to achieve the following skills.
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
@if ($skills_failed->count() > 0 && !$graduated)
@component('mail::panel')
## Skills needed for graduation
@foreach ($skills_failed as $progressReport)
✗ {{ $progressReport->skill->description }}<br>
@endforeach
@endcomponent
@endif

@if ($graduated)
We're so proud of you! Your Graduation Diploma for the {{$lesson->group->type}} is attached to this email. We look forward to continuing to swim with you in the next level.
@else
We're proud of your accomplishments so far! Keep practicing and working hard in the {{$lesson->group->type}}, and you'll be ready to graduate to the next level very soon!
@endif

See you at the pool,<br>
The Swim School
@endcomponent
