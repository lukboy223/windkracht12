<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'relation_number',
        'isactive',
        'remark',
        'street_name',
        'house_number',
        'postal_code',
        'place',
        'addition',
        'mobile',
        'email',
    ];
}
