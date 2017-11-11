@component('mail::message')
{{$subject}}

- Name: {{$data['name']}}
- Phone: {{$data['phone']}}
- Email: {{$data['email']}}
- Message: {{$data['message']}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
