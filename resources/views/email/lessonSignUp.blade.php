@component('mail::message')
# {{$lesson->group->type}}

Thanks for signing up for {{$lesson->group->type}} swim lessons.

@component('mail::panel')
### Time
    <p>
        The first class is {{$lesson->class_start_date->format('l F jS')}}, {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.
    </p>
@endcomponent

@component('mail::panel')
### Place
    <p>
        {{$lesson->location->street}},
        {{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}
    </p>
@endcomponent

@component('mail::panel')
### What To Bring
* Swimwear
* Towel
* Goggles
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
