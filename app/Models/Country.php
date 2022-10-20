<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_uid',
        'name',
        'slug',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'country_uid';
    }

    /**
     * Relationship between the country and boundaries
     */
    public function boundaries ()
    {
        return $this->hasMany(Boundary::class, 'country_uid', 'country_uid');
    }
}
