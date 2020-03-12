@component('mail::message')
# Password Reset

Your new password is {{ $password }}

@component('mail::button', ['url' => url('/login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
