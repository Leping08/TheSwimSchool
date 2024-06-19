@component('mail::message')
# Congratulations!

{{ $swimmer->firstName }}, you have successfully completed your {{$lesson->group->type}} swim lessons. We hope you had a great time and learned a lot.\
Please find your certificate attached.

Thanks,<br>
The Swim School
@endcomponent
