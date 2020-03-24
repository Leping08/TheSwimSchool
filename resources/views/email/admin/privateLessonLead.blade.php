@component('mail::message')
# Private Lesson Request

@component('mail::panel')
* Name: {{$privateLessonLead->swimmer_name}}
* Age: {{\Carbon\Carbon::now()->diffInYears($privateLessonLead->swimmer_birth_date)}} {{\Illuminate\Support\Str::plural('year', \Carbon\Carbon::now()->diffInYears($privateLessonLead->swimmer_birth_date))}} old
* Email: {{$privateLessonLead->email}}
* Phone: {{$privateLessonLead->phone}}
* Type: {{$privateLessonLead->type}}
* Package: {{$privateLessonLead->length}}
* Location: {{$privateLessonLead->location}}
@if($privateLessonLead->address)* Address: {{$privateLessonLead->address}}@endif

* Harrison Ranch Resident: @if($privateLessonLead->hr_resident) Yes @else No @endif

* Availability: {{$privateLessonLead->availability}}
@endcomponent

@component('mail::button', ['url' => config('app.url').'admin/resources/private-lesson-requests/'.$privateLessonLead->id])
View Details
@endcomponent


@endcomponent
