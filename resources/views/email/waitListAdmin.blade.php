@component('mail::message')
# Lesson Wait List Filling Up

@component('mail::panel')
The wait list for the {{$lesson->group->type}} @foreach($lesson->DaysOfTheWeek as $day){{$day->day}}{{$loop->last ? '' : ', '}}@endforeach
{{$lesson->class_start_time->format('h:i a')}} - {{$lesson->class_end_time->format('h:i a')}} has {{$lesson->waitlist->count()}} people on the wait list.
@endcomponent

@component('mail::panel')
### Lesson Details
* Name: {{$lesson->group->type}}
* Price: ${{$lesson->price}}
* Size: {{$lesson->class_size}}
* Location: {{$lesson->location->name}}
* Dates: {{$lesson->class_start_date->format('m/d')}} - {{$lesson->class_end_date->format('m/d')}}
* Time: {{$lesson->class_start_time->format('h:i a')}} - {{$lesson->class_end_time->format('h:i a')}}
* Days: @foreach($lesson->DaysOfTheWeek as $day){{$day->day}}{{$loop->last ? '' : ', '}}@endforeach
@endcomponent

@component('mail::button', ['url' => config('app.url').'admin/resources/lesson/'.$lesson->id])
View Lesson
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
