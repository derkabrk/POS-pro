<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'status',
    ];

    protected $casts =[
        'status' => 'integer',
    ];
}
