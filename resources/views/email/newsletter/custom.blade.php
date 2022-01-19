@component('mail::message')

<img style="margin-bottom: 2em;" src="{{ $image_url }}" alt="">

@component('mail::panel')
{!! \Illuminate\Mail\Markdown::parse($body) !!}
@endcomponent

@component('mail::button', ['url' => "{$button_url}?utm_source=newsletter&utm_medium=email&utm_campaign=newsletter"])
{{ $button_text }}
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
