@component('mail::message')

@slot('header')
    My Header
@endslot

Dear {{ $name }}:

To confirm your {{ config('app.name') }} account:

* Click the following confirmation link: {{ $link }}
* Login using your email address {{ $email }} and the password you created.

@component('mail::button', ['url' => $link])
    Confirm Invitation
@endcomponent

If other members of your team need access, please contact APS.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
