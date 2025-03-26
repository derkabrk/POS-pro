<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\BusinessType;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_subscribe_id',
        'business_category_id',
        'companyName',
        'address',
        'phoneNumber',
        'pictureUrl',
        'will_expire',
        'subscriptionDate',
        'remainingShopBalance',
        'shopOpeningBalance',
        'vat_name',
        'vat_no',
        "type",
    ];

    public function getTypeTextAttribute()
{
    $types = [
        0 => 'Physical',
        1 => 'E-commerce',
        2 => 'Both',
    ];

    return $types[$this->type] ?? 'Unknown';
}
    public function enrolled_plan()
    {
        return $this->belongsTo(PlanSubscribe::class, 'plan_subscribe_id');
    }

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }
}
