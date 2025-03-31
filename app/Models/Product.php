<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'productName',
        'supplier_id',
        'business_id',
        'unit_id',
        'brand_id',
        'vat_id',
        'vat_type',
        'vat_amount',
        'profit_percent',
        'category_id',
        'productCode',
        'productPicture',
        'productDealerPrice',
        'productPurchasePrice',
        'productSalePrice',
        'productWholeSalePrice',
        'productStock',
        'alert_qty',
        'expire_date',
        'size',
        'meta',
        'color',
        'weight',
        'capacity',
        'productManufacturer',
    ];

    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
    ];
}
