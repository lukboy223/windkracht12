<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

   public function instructor()
{
    return $this->belongsTo(\App\Models\instructor::class, 'instructor_id');
}
    public function registration()
    {
        return $this->belongsTo(\App\Models\Registration::class, 'registration_id');
    }
}
