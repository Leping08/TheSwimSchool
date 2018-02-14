@component('mail::message')

@component('mail::panel')
###{{$subject}} Lead
* Name: {{$data['name']}}
* Phone: {{$data['phone']}}
* Email: {{$data['email']}}
* Message: {{$data['message']}}
@endcomponent


@endcomponent
