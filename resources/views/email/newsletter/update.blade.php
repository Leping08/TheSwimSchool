@component('mail::message')
# The Swim School is Moving!

@component('mail::panel')
<img style="margin-bottom: 2em;" src="{{asset('img/lessons/realhab.png')}}" alt="">

<p>
We are very excited to announce we are moving our private lesson and group class swim programs to a brand new state of the art, indoor pool facility located conveniently along US 301 North in Parrish. Our new home will be at Realhab Physical Therapy, Aquatics and Wellness Center, 12159 US Highway 301 N., Parrish FL 34219!
</p>
<p>
Our transition has already begun with private swim lessons now taking place at this new location, and will continue with our next session of group classes starting there May 3rd for weekday sessions and May 29th for weekend sessions. The River Wilderness Golf & Country Club will remain our home for the Flying Fish & Shark swim club as well as the Parrish Bull Sharks swim team programs.
</p>
<p>
You will now see updates to our website including banner messages with the dates we are moving each program, changes to our address location, and a price adjustment to accommodate moving to our new home. We are looking forward to now offering the majority of our swim programs year round with no worry about inclement weather, cold water temperatures, sunscreen and pesky insects! We will also be training and hiring some additional staff with this new ability to expand our services. We promise to always strive for excellence in the services we provide while maintaining the most affordable prices possible. Please contact us directly with any questions. We look forward to diving in with you at this new pool very soon!
</p>
@endcomponent

@component('mail::button', ['url' => route('home.index') .'?utm_source=newsletter&utm_medium=email&utm_campaign=new_location'])
Learn More
@endcomponent

Thanks,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
