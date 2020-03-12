@component('mail::message')
# {{ $data->subject }}

{{ $data->description }}

@component('mail::button', ['url' => route('messages.index')])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
