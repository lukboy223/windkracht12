<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    public function instructor()
    {
        return $this->belongsTo(\App\Models\Instructor::class, 'instructor_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
