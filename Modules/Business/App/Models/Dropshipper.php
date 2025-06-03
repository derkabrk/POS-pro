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
    ];
}
