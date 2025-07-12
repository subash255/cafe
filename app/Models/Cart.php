<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'fooditem_id',
        'user_id',
        'quantity',
        'price',
    ];

    public function fooditem()
    {
        return $this->belongsTo(Fooditems::class, 'fooditem_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
