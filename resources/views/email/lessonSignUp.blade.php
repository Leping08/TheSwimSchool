@component('mail::message')
# The Swim School

We see you have signed up for swim lessons through the swim school.

@component('mail::button', ['url' => ''])
View Lesson Details
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
