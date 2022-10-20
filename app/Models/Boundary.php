<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boundary extends Model
{
    use HasFactory;

    protected $fillable = [
        'boundary_uid',
        'name',
        'level',
        'country_uid',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'boundary_uid';
    }

    /**
     * Relationship between the boundary and a country
     */
    public function country ()
    {
        return $this->belongsTo(Country::class, 'country_uid', 'country_uid');
    }
}
