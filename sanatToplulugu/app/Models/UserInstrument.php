<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInstrument extends Model
{
    protected $fillable = [
        'user_id',
        'instrument_id'
    ];

    /**
     * Get the user that owns the user instrument.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the instrument.
     */
    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
