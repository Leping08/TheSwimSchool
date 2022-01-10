@component('mail::message')

<img style="margin-bottom: 2em;" src="{{ $image_url }}" alt="">

@component('mail::panel')
{!! \Illuminate\Mail\Markdown::parse($body) !!}
@endcomponent

@component('mail::button', ['url' => "{$button_url}?utm_source=newsletter&utm_medium=email&utm_campaign=new_location"])
{{ $button_text }}
@endcomponent


@endcomponent
