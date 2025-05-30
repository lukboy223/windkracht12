@component('mail::message')
# Welkom bij Windkracht12

<div style="color: #22223b; line-height: 1.6;">
Bedankt voor je registratie bij onze kitesurfschool!

Bij Windkracht 12 draait alles om passie voor de wind, de zee en de vrijheid van het kitesurfen. We zijn blij dat je je hebt aangemeld en kijken ernaar uit om je te verwelkomen.
</div>

<div style="margin: 25px 0; padding: 15px; background-color: #CAE9FF; border-left: 4px solid #1B4965; border-radius: 4px;">
Klik op de onderstaande knop om je account te activeren en je registratie te voltooien. 
<br><br>
Tijdens het activeren zul je gevraagd worden om een wachtwoord aan te maken en je persoonlijke gegevens in te vullen.
</div>

@component('mail::button', ['url' => route('registration.complete.form', ['token' => $token, 'email' => $user->email]), 'color' => 'primary'])
<h3>
    Activeer mijn account
</h3> 
@endcomponent

<div style="color: #555; font-size: 0.9em; margin-top: 20px;">
Deze link is 24 uur geldig.
<br>
Als je deze e-mail niet hebt aangevraagd, kun je deze veilig negeren.
</div>

Met vriendelijke groet,<br>
**Het team van Windkracht 12**

<div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 0.8em; color: #777;">
© {{ date('Y') }} Windkracht 12. Alle rechten voorbehouden.
</div>
@endcomponent
