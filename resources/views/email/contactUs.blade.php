@component('mail::message')
# {{$subject}} Lead

@component('mail::panel')
* Name: {{$data['name']}}
* Phone: {{$data['phone']}}
* Email: {{$data['email']}}
* Message: {{$data['message']}}
@endcomponent

@component('mail::button', ['url' => config('app.url').'lead/'.$data->id])
    View Details
@endcomponent

@endcomponent
