@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/email/new_phone_number.png') }}">

@component('mail::panel')
# New Year, New Business Phone Number!
I hope you all had a wonderful holiday season! My staff and I look forward to seeing you back in the pool very soon! Before we dive into 2022, I wanted to let you know we are starting off the new year with a new phone number!

The Swim School now has an official business phone line and the new number is **{{ config('contact.phone.number') }}**. You can reach us by either calling this number, sending a message through the “Contact Us” section of the website, or sending an email to **{{ config('contact.email.address') }}**. The previous phone number is no longer in service, so please update our contact details.

In regards to our winter swim programs, private lessons for the month of January are already open for registration through the website. The first weekday session of group lessons and swim club opens for registration tomorrow Monday, January 3rd and the first weekend session of group lessons opens for registration Monday, January 10th.
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=new_phone_number'])
Learn More
@endcomponent

{{-- @component('mail::button', ['url' => route('groups.schedule.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
View Schedule
@endcomponent --}}

{{-- @component('mail::panel')
# November Private Lessons, Final Group Session of 2021, and New Instructor!
Registration is now open for our available private swim lessons for the month of November and our final weekday session of group classes & swim club for the year. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent --}}

{{-- @component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent --}}

Cheers to the new year,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
