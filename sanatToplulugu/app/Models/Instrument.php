<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    protected $fillable = [
        'name',
        'category', 
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that play this instrument.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_instruments')
                    ->withTimestamps();
    }

    /**
     * Get the user instrument details.
     */
    public function userInstruments()
    {
        return $this->hasMany(UserInstrument::class);
    }
}
