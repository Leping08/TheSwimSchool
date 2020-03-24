@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/backstroke_kickboard.jpg')}}">

@component('mail::panel')
# 2020 Swim Season
The 2020 swim season is here and while The Swim School is hoping to be back in the pool with programs starting March 30th, we are aware of the growing concerns and rapidly changing restrictions regarding COVID-19. Even though all of our programs (group classes, private lessons and pre-season swim team training) allow us to operate with groups of less than 10 participants and our outdoor pool is located in a privately owned facility with minimal community exposure, your family’s health and safety is our main priority. At this time, our goal is to provide you with our current 2020 swim season schedule and allow you to start registering your children in our programs through our website online. You can check out our website for more details and get signed up now. We are also able to provide mobile private lesson services to your home pool within our service area. We will keep you informed if any schedule changes need to occur and we do plan to put additional on site safety protocols in place to protect the children and families we serve for as long as the risk of COVID-19 transmission exists. We look forward to swimming with you very soon!
@endcomponent

@component('mail::button', ['url' => config('app.url').'lessons?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{config('app.url')}}unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
