@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}" alt="">

# Feedback

Thank you for participating in an aquatics program through The Swim School! To help us serve you better and improve our programs, we need your feedback. Please take a few minutes to complete this evaluation form regarding your recent experience with The Swim School.

@component('mail::button', ['url' => config('app.url').'feedback'])
Leave Feedback
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
