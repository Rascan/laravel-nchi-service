<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurisdiction extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurisdiction_uid',
        'name',
        'boundary_uid',
        'parent_uid',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'jurisdiction_uid';
    }

    /**
     * Relationship between the jurisdiction and the boundary
     */
    public function boundary ()
    {
        return $this->belongsTo(Boundary::class, 'boundary_uid', 'boundary_uid');
    }

    /**
     * Relationship between the jurisdiction and its parent
     */
    public function parent ()
    {
        return $this->belongsTo(Jurisdiction::class, 'parent_uid', 'jurisdiction_uid');
    }

    /**
     * Relationship between the jurisdiction and its chidlren
     */
    public function children ()
    {
        return $this->hasMany(Jurisdiction::class, 'parent_uid', 'jurisdiction_uid');
    }
}
