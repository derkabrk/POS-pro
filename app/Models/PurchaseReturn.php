<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'purchase_id',
        'invoice_no',
        'return_date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = PurchaseReturn::where('business_id', auth()->user()->business_id)->count() + 1;
            $model->invoice_no = "PR" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseReturnDetail::class);
    }
}
