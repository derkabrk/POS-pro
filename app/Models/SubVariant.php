<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'business_id',
        'name',
        'sku',
        'status',
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
