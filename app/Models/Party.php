<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'due',
        'image',
        'status',
        'address',
        'business_id',
    ];

    public function sales_dues()
    {
        return $this->hasMany(\App\Models\Sale::class, 'party_id')->where('dueAmount', '>', 0);
    }

    public function purchases_dues()
    {
        return $this->hasMany(\App\Models\Purchase::class, 'party_id')->where('dueAmount', '>', 0);
    }
}
