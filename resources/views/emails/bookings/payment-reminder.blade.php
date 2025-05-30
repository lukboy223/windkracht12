@component('mail::message')
# Betaling herinneringen voor je boeking

<div style="color: #22223b; line-height: 1.6;">
Beste {{ $booking->user->name }},

We hebben je boeking voor kitesurfles succesvol ontvangen, maar de betaling is nog niet voltooid.
</div>

<div style="margin: 25px 0; padding: 15px; background-color: #CAE9FF; border-left: 4px solid #1B4965; border-radius: 4px;">
<strong>Details van je boeking:</strong>
<br><br>
Lespakket: {{ $package->name }}<br>
Datum: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}<br>
Tijd: {{ $booking->booking_time === 'morning' ? 'Ochtend (9:00-12:30)' : 'Middag (13:00-16:30)' }}<br>
Aantal personen: {{ $booking->participants }}<br>
Te betalen bedrag: €{{ number_format($amount, 2, ',', '.') }}
</div>

<p>Om je boeking te bevestigen, dien je de betaling te voltooien. Klik op de onderstaande knop om direct naar de betaalpagina te gaan.</p>

@component('mail::button', ['url' => route('payments.create', ['booking_id' => $booking->id, 'amount' => $amount]), 'color' => 'primary'])
<h3>
    Nu betalen
</h3>
@endcomponent

<div style="color: #555; font-size: 0.9em; margin-top: 20px;">
Als je vragen hebt over je boeking, neem dan gerust contact met ons op.
</div>

Met vriendelijke groet,<br>
**Het team van Windkracht 12**

<div style="margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 0.8em; color: #777;">
© {{ date('Y') }} Windkracht 12. Alle rechten voorbehouden.
</div>
@endcomponent
