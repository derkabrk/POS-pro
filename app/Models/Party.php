<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'due',
        'image',
        'status',
        'address',
        'business_id',
    ];

    public function sales_dues() : HasMany
    {
        return $this->hasMany(Sale::class)->where('dueAmount', '>', 0);
    }

    public function purchases_dues() : HasMany
    {
        return $this->hasMany(Purchase::class)->where('dueAmount', '>', 0);
    }

    public function dueCollect()
    {
        return $this->hasOne(DueCollect::class);
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due' => 'double',
    ];
}
