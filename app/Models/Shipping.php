<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model as EloquentModel;


class Shipping extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipping_company_id',
        'business_id',
        'name',
        'shipping_company',
        'first_r_credential',
        'second_r_credential',
        'shops',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'shops' => 'array',
    ];
    public function shipping_company()
    {
        return $this->belongsTo(ShippingCompanies::class, 'shipping_company_id');
    }

    public function business()
    {
    return $this->belongsTo(Business::class, 'business_id');
    }
}
