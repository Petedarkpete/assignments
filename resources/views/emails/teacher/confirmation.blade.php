@component('mail::message')
# Hello {{ $teacherName }},

Your account has been successfully confirmed.

Thank you for joining our team!

{{-- @component('mail::button', ['url' => url('/')])
Visit Dashboard
@endcomponent

Thanks, --}}
{{ config('app.name') }}
@endcomponent
