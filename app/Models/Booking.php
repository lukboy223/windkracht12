<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_date',
        'booking_time',
        'participants',
        'partner_name',
        'notes',
        'status',
        'isactive',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'isactive' => 'boolean',
        'participants' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    public function registration()
    {
        return $this->hasOne(Registration::class);
    }
}
