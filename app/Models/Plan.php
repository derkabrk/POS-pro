<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'duration',
        'offerPrice',
        'subscriptionName',
        'subscriptionPrice',
        'features',
        'permissions',
        'marketplace_feature',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'json',
        'permissions' => 'json',
        'marketplace_feature' => 'boolean',
    ];

    public function planSubscribes()
    {
        return $this->hasMany(\App\Models\PlanSubscribe::class, 'plan_id');
    }
}
