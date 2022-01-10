@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/email/january_registration.png') }}">

@component('mail::panel')
# January Registration Is Now Open for All Swim Programs!

Registration is now open for all of our swim programs starting in January including group swim lessons, private swim lessons, and the Flying Fish and Shark swim club. As a reminder, The Swim School now has an official business phone line and the new number is **941-981-5716**. You can reach us by either calling this number, sending a message through the “Contact Us” section of the website, or sending an email to **info@theswimschoolfl.com**. The previous phone number is no longer in service, so please update our contact details. We are looking forward to seeing you at the pool soon!
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=new_phone_number'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
