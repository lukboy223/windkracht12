@component('mail::message')
# Betalingsbevestiging en lesdetails

<div style="color: #22223b; line-height: 1.6;">
Beste {{ $booking->user->name }},

Bedankt voor je betaling! Je boeking voor kitesurfles bij Windkracht 12 is nu volledig bevestigd.
</div>

<div style="margin: 25px 0; padding: 15px; background-color: #e6f7e6; border-left: 4px solid #28a745; border-radius: 4px;">
<strong>Details van je boeking:</strong>
<br><br>
Lespakket: {{ $package->name }}<br>
Datum: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}<br>
Tijd: {{ $booking->booking_time === 'morning' ? 'Ochtend (9:00-12:30)' : 'Middag (13:00-16:30)' }}<br>
Aantal personen: {{ $booking->participants }}<br>
Instructeur: {{ $lesson->instructor->user->name }}<br>
Locatie: {{ $lesson->location ?: 'Main Beach' }}
</div>

<div style="margin: 25px 0;">
<strong>Wat te verwachten:</strong>
<ul style="padding-left: 20px;">
    <li>Kom 15 minuten voor aanvang van je les, zodat je op tijd kunt beginnen.</li>
    <li>Neem zwemkleding, een handdoek en zonbescherming mee.</li>
    <li>Alle benodigde kitesurf-uitrusting wordt door ons verzorgd.</li>
</ul>
</div>

@if($package->id === 'duo-three' || $package->id === 'duo-five')
<div style="padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px; margin: 25px 0;">
<strong>Meerdere lessen:</strong><br>
Dit pakket bevat {{ $package->id === 'duo-three' ? '3' : '5' }} lessen. De eerste les is nu ingepland, de overige lessen worden in overleg met je instructeur gepland.
</div>
@endif

<div style="color: #555; margin-top: 20px;">
Als je vragen hebt of je les moet annuleren/verplaatsen, neem dan minimaal 24 uur van tevoren contact met ons op.
</div>

@component('mail::button', ['url' => route('lessons.index'), 'color' => 'success'])
<h3>
    Bekijk je les
</h3>
@endcomponent

Met vriendelijke groet,<br>
**Het team van Windkracht 12**

<div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 0.8em; color: #777;">
© {{ date('Y') }} Windkracht 12. Alle rechten voorbehouden.<br>
Telefoon: 06-12345678 | Email: info@windkracht12.nl
</div>
@endcomponent
