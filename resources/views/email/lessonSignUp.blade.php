@component('mail::message')
# {{$lesson->group->type}}

Thanks for signing up for {{$lesson->group->type}} swim lessons.

@component('mail::panel')
### Time
The first class is {{$lesson->class_start_date->format('l F jS')}}, {{$lesson->class_start_time->format('H:i A')}} - {{$lesson->class_start_end->format('H:i A')}}.
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

@component('mail::button', ['url' => ''])
View Lesson Details
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
