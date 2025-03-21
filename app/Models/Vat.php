<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'status',
        'sub_vat',
        'business_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'double',
        'sub_vat' => 'json',
        'status' => 'boolean',
        'business_id' => 'integer',
    ];
}
