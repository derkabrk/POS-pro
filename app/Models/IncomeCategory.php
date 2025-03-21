<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryName',
        'business_id',
        'categoryDescription',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
