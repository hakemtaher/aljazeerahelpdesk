<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'assigned_user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'array',
    ];

    /**
     * Get the department name according to the current application locale.
     *
     * @return array
     */
    public function getNameAttribute($value)
    {
        //$locale = app()->getLocale();
        $name = json_decode($value, true);

        // If the name exists for the current locale, return it. Otherwise, fallback to a default (e.g., English).
        return $name;//[$locale] ?? $name['en'] ?? 'Unnamed Department';
    }
}
