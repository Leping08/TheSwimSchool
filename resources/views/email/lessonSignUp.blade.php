@component('mail::message')
# {{$lesson->group->type}}

Thanks for signing up for {{$lesson->group->type}} swim lessons.

@component('mail::panel')
### Time
The first class is {{$lesson->class_start_date->format('l F jS')}}, {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.
@endcomponent

@component('mail::panel')
### Place
{{$lesson->location->street}},
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}
@endcomponent

@component('mail::panel')
### What To Bring
* Swimwear
* Towel
* Goggles
@endcomponent

<!-- TODO: Make the button link to the lesson -->
@component('mail::button', ['url' => ''])
View Lesson Details
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
