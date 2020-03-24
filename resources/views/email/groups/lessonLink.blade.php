@component('mail::message')
# Reserve Swim Lessons

Your registration link for your swim lessons is now ready! To reserve your session of swim lessons with The Swim School, please click on the button below to complete online registration.

Please contact us if you have any questions regarding the registration process. We look forward to swimming with you soon!

@component('mail::button', ['url' => config('app.url').'lessons/'.$lesson->group->type.'/'.$lesson->id])
Reserve Lessons
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
