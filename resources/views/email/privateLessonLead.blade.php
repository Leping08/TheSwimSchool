@component('mail::message')
# Private Lesson Request

@component('mail::panel')
* Name: {{$privateLessonLead->swimmer_name}}
* Age: {{\Carbon\Carbon::now()->diffInYears($privateLessonLead->swimmer_birth_date)}} {{str_plural('year', \Carbon\Carbon::now()->diffInYears($privateLessonLead->swimmer_birth_date))}} old
* Email: {{$privateLessonLead->email}}
* Phone: {{$privateLessonLead->phone}}
* Type: {{$privateLessonLead->type}}
* Package: {{$privateLessonLead->length}}
* Location: {{$privateLessonLead->location}}
* Availability: {{$privateLessonLead->availability}}
@endcomponent

@component('mail::button', ['url' => config('app.url').'private-semi-private/lead/'.$privateLessonLead->id])
View Details
@endcomponent


@endcomponent
