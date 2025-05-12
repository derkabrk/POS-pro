<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mode',
        'data',
        'image',
        'status',
        'charge',
        'is_manual',
        'namespace',
        'accept_img',
        'manual_data',
        'manual_data',
        'currency_id',
        'instructions',
        'phone_required',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
        'manual_data' => 'json',
    ];
}
