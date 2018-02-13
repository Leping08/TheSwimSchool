@component('mail::message')
# Class Full

{{$lesson->group->type}} is full. You should consider adding a similar lesson.

@component('mail::panel')
    ### Lesson Details
    * Lesson: {{$lesson->group->type}}
    * Price: {{$lesson->price}}
    * Class Size: {{$lesson->class_size}}
    * Start Date: {{$lesson->class_start_date}}
    * End Date: {{$lesson->class_end_date}}
    * Days: @foreach($lesson->DaysOfTheWeek as $day) $day->day @endforeach
    * Class Time: {{$lesson->class_start_time}}-{{$lesson->class_end_time}}
    * Location: {{$lesson->location->name}}
@endcomponent

@component('mail::button', ['url' => "/lesson/$lesson->id"])
View Lesson
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
