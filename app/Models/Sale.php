<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'party_id',
        'user_id',
        'discountAmount',
        'discount_percent',
        'discount_type',
        'sale_type',
        'delivery_fees',
        'shipping_charge',
        'dueAmount',
        'isPaid',
        'vat_amount',
        'vat_percent',
        'vat_id',
        'sale_status',
        'paidAmount',
        'lossProfit',
        'totalAmount',
        'paymentType',
        'payment_type_id',
        'invoiceNumber',
        'saleDate',
        'image',
        'meta',
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetails::class);
    }

    public function party() : BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function saleReturns()
    {
        return $this->hasMany(SaleReturn::class, 'sale_id');
    }

    public function vat() : BelongsTo
    {
        return $this->belongsTo(Vat::class);
    }

    public function payment_type() : BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = Sale::where('business_id', auth()->user()->business_id)->count() + 1;
            $model->invoiceNumber = "S" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'vat_id' => 'integer',
        'discountAmount' => 'double',
        'dueAmount' => 'double',
        'isPaid' => 'boolean',
        'vat_amount' => 'double',
        'vat_percent' => 'double',
        'paidAmount' => 'double',
        'totalAmount' => 'double',
        'delivery_fees' => 'double',
        'shipping_charge' => 'double',
        'meta' => 'json',
    ];

    public const STATUS = [
        1 => 'Pending',
        2 => 'Called 1',
        3 => 'Called 2',
        4 => 'Called 3',
        5 => 'Called 4',
        6 => 'Canceled',
        7 => 'Confirmed',
        8 => 'Shipping',
        9 => 'Returned',
        10 => 'Delivered',
        11 => 'Paid',
        12 => 'Cash Out',
    ];

    // Accessor to get status name
    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->sale_status] ?? 'Unknown';
    }
}
