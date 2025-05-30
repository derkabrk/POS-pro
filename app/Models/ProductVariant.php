<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'variantName',
        'variantCode',
        'status',
        'business_id',
    ];

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'product_product_variant');
    }

    public function subVariants()
    {
        return $this->hasMany(SubVariant::class, 'product_variant_id');
    }
}
