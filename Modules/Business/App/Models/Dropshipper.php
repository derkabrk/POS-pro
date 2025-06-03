<?php

namespace Modules\Business\App\Models;

use Illuminate\Database\Eloquent\Model;

class Dropshipper extends Model
{
    protected $fillable = [
        'store',
        'phone',
        'full_name',
        'total_orders',
        'delivered',
        'returned',
        'pending',
        'available',
        'paid',
        'cashout',
        'expires',
        'business_id',
        'user_id',
    ];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
