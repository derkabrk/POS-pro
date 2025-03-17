<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'party_id',
        'business_id',
        'discountAmount',
        'discount_percent',
        'discount_type',
        'shipping_charge',
        'dueAmount',
        'paidAmount',
        'totalAmount',
        'invoiceNumber',
        'vat_id',
        'vat_amount',
        'vat_percent',
        'isPaid',
        'paymentType',
        'payment_type_id',
        'purchaseDate',
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function vat() : BelongsTo
    {
        return $this->belongsTo(Vat::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function party() : BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class, 'purchase_id');
    }

    public function payment_type() : BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = Purchase::where('business_id', auth()->user()->business_id)->count() + 1;
            $model->invoiceNumber = "P" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'vat_id' => 'integer',
        'isPaid' => 'boolean',
        'discountAmount' => 'double',
        'dueAmount' => 'double',
        'paidAmount' => 'double',
        'totalAmount' => 'double',
    ];
}
