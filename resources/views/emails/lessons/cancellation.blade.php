@component('mail::message')
# Les Geannuleerd

<div style="color: #22223b; line-height: 1.6;">
Beste {{ $recipient->name }},

Er is een wijziging in de geplande kitesurfles.
</div>

<div style="margin: 25px 0; padding: 15px; background-color: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px;">
<strong>De volgende les is geannuleerd:</strong>
<br><br>
Datum: {{ \Carbon\Carbon::parse($lesson->start_date)->format('d-m-Y') }}<br>
Tijd: {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}<br>
Locatie: {{ $lesson->registration->booking->location ?: 'Main Beach' }}<br>
<br>
Reden voor annulering:<br>
{{ $reason }}
</div>

@if($isInstructor)
<p>De student is op de hoogte gebracht van deze annulering. Gelieve contact op te nemen om een nieuwe les in te plannen.</p>
@else
<p>Je instructeur is op de hoogte gebracht van deze annulering. Er zal contact worden opgenomen om een nieuwe les in te plannen.</p>
@endif

@component('mail::button', ['url' => route('lessons.index'), 'color' => 'primary'])
<h3>
    Bekijk Lesoverzicht
</h3>
@endcomponent

<div style="color: #555; font-size: 0.9em; margin-top: 20px;">
Voor vragen of meer informatie, neem contact op met ons via telefoon of e-mail.
</div>

Met vriendelijke groet,<br>
**Het team van Windkracht 12**

<div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 0.8em; color: #777;">
© {{ date('Y') }} Windkracht 12. Alle rechten voorbehouden.<br>
Telefoon: 06-12345678 | Email: info@windkracht12.nl
</div>
@endcomponent
