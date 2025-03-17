<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'invoice_no',
        'business_id',
        'return_date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = SaleReturn::where('business_id', auth()->user()->business_id)->count() + 1;
            $model->invoice_no = "SR" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function details()
    {
        return $this->hasMany(SaleReturnDetails::class);
    }
}
