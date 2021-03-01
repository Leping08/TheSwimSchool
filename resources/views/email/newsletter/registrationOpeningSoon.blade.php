@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/smile.jpg')}}" alt="">

@component('mail::panel')
# 2021 Swim Season Is Almost Here!
We can’t wait to splash around and make waves at the pool again as soon as the water warms up! Our <a href="{{ route('groups.schedule.index') }}">2021 session schedule</a> is now available to view on the website and registration will open for our first session of group classes, private lessons and spring swim club on Monday, March 15th. We are also very excited to announce that we WILL be able to have a summer swim team season this year! Stay tuned for more swim team details coming in April.
@endcomponent

@component('mail::button', ['url' => config('app.url').'?utm_source=newsletter&utm_medium=email&utm_campaign=spring_lesson_registration_coming_soon'])
    Visit Site
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
