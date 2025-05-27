<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'package_id',
        'booking_id',
        'start_date',
        'end_date',
        'isactive',
        'remark',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'isactive' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
