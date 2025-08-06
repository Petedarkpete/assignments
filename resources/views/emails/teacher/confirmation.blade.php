@component('mail::message')
# Hello {{ $teacherName }},

Your account has been successfully confirmed.

To activate your account and begin using the system, please set your username and password using the button below.
**This link will expire in 30 minutes and can only be used once.**

@component('mail::button', ['url' => url('/activation/' . $activationToken)])
Set Your Credentials
@endcomponent

If you did not request this or believe it's a mistake, please ignore this message or contact support.

Thanks,
{{ config('app.name') }}
@endcomponent
