@component('mail::message')
# Project Invitation

Hello!

User {{ $userName }} has invited you to join project "{{ $projectName }}".

If you think this is a mistake ignore this email.

@component('mail::button', ['url' => '#'])
    View Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
