<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fooditems extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
