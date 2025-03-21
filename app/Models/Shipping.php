<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\BusinessType;
>>>>>>> fa84ff07fb843d5061240878ab37664ebb48c2c6

class Shipping extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipping_company_id',
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
>>>>>>> fa84ff07fb843d5061240878ab37664ebb48c2c6
}
