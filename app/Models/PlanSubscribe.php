<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanSubscribe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'notes',
        'plan_id',
        'duration',
        'gateway_id',
        'business_id',
        'payment_status',
    ];

    protected $casts = [
        'notes' => 'json'
    ];

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function gateway() : BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
