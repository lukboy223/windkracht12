@component('mail::message')
# Welkom bij Windkracht12

Bedankt voor je registratie!

Klik op de onderstaande knop om je account te activeren en een wachtwoord in te stellen:

@component('mail::button', ['url' => $url])
Activeer Account
@endcomponent

Deze link is 24 uur geldig.

Als je deze e-mail niet hebt aangevraagd, kun je deze veilig negeren.

Met vriendelijke groet,<br>
Het team van Windkracht12
@endcomponent
