<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'date',
        'time',
        'people',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
