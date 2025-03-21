<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DueCollect extends Model
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
        'sale_id',
        'purchase_id',
        'invoiceNumber',
        'totalDue',
        'dueAmountAfterPay',
        'payDueAmount',
        'paymentType',
        'payment_type_id',
        'paymentDate',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $id = DueCollect::where('business_id', auth()->user()->business_id)->count() + 1;
            $model->invoiceNumber = "D" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function party() : BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    public function sale() : BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function purchase() : BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function payment_type() : BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'party_id' => 'integer',
        'payDueAmount' => 'double',
    ];
}
