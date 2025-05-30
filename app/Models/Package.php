<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'duration',
        'price',
        'description',
        'features',
        'isactive',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'float',
        'isactive' => 'boolean',
    ];

    /**
     * Get the bookings for this package.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
