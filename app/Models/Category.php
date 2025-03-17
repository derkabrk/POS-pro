<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categoryName',
        'business_id',
        'variationCapacity',
        'variationColor',
        'variationSize',
        'variationType',
        'variationWeight',
        'icon',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'variationSize' => 'boolean',
        'variationColor' => 'boolean',
        'variationCapacity' => 'boolean',
        'variationType' => 'boolean',
        'variationWeight' => 'boolean',
    ];
}
