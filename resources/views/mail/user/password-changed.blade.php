@component('emails.layouts.main')
<p>Hi <strong>{{ $user->username }}</strong>,</p>

<p>Your password has been changed (IP: {{ $ip }}). If you did not request this change, please contact us immediately.</p>

<p>Thanks,<br/>{{ config('app.name') }}</p>
@endcomponent
