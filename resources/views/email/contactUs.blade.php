@component('mail::message')
Contact Us Contact Form

- Name: {{$data['name']}}
- Phone: {{$data['phone']}}
- Email: {{$data['email']}}
- Message: {{$data['message']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
