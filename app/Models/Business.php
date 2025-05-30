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
        'subdomain',
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

    /**
     * Get the current (active) plan subscription for the business.
     */
    public function getCurrentPackage()
    {
        return $this->enrolled_plan();
    }

    public function enrolled_plan()
    {
        return $this->belongsTo(PlanSubscribe::class, 'plan_subscribe_id');
    }

    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    /**
     * Get the owner user of the business.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Generate a unique, DNS-safe subdomain for a business based on company name or random string.
     */
    public static function generateUniqueSubdomain($companyName)
    {
        // Convert to slug, allow only a-z, 0-9, hyphens, max 30 chars
        $base = strtolower(preg_replace('/[^a-z0-9]+/', '-', $companyName));
        $base = trim($base, '-');
        $base = substr($base, 0, 30);
        $subdomain = $base;
        $i = 1;
        while (self::where('subdomain', $subdomain)->exists()) {
            $subdomain = $base . ($i++);
        }
        return $subdomain;
    }
}
