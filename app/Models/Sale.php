<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
        'delivery_address',
        'shipping_service_id',
        'tracking_id',
        'delivery_type',
        'parcel_type',
        'products',
        'party_id',
        'wilaya_id',
        'commune_id',
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

    
    public function shippings() : BelongsTo
    {
        return $this->belongsTo(Shipping::class);
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
        static::creating(function ($model) {
            $model->tracking_id = 'TRK-' . Str::upper(Str::random(10));
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
        'delivery_type' => 'integer',
        'meta' => 'json',
    ];

        public function getProductsAttribute($value)
        {
        return json_decode($value, true) ?? [];
        }

         public function setProductsAttribute($value)
         {
         $this->attributes['products'] = json_encode($value);
         }

    public const STATUS = [
        1 => ['name' => 'Pending', 'color' => 'bg-warning'], // Yellow
        2 => ['name' => 'Called 1', 'color' => 'bg-info'], // Light Blue
        3 => ['name' => 'Called 2', 'color' => 'bg-info'], // Light Blue
        4 => ['name' => 'Called 3', 'color' => 'bg-info'], // Light Blue
        5 => ['name' => 'Called 4', 'color' => 'bg-info'], // Light Blue
        6 => ['name' => 'Canceled', 'color' => 'bg-danger'], // Red
        7 => ['name' => 'Confirmed', 'color' => 'bg-primary'], // Blue
        8 => ['name' => 'Shipping', 'color' => 'bg-secondary'], // Grey
        9 => ['name' => 'Returned', 'color' => 'bg-dark'], // Dark Grey
        10 => ['name' => 'Delivered', 'color' => 'bg-success'], // Green
        11 => ['name' => 'Paid', 'color' => 'bg-success'], // Green
        12 => ['name' => 'Cash Out', 'color' => 'bg-primary'], // Blue
    ];




    // Accessor to get status name
    public function getStatusNameAttribute()
    {
        return self::STATUS[$this->sale_status] ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        return self::STATUS[$this->sale_status]['color'] ?? 'bg-secondary';
    }

    public static function getNextStatuses($currentStatus)
    {
        $transitions = [
            1 => [2, 6, 7], // Pending → Called 1, Confirmed, Canceled
            2 => [3, 6, 7], // Called 1 → Called 2, Confirmed, Canceled
            3 => [4, 6, 7], // Called 2 → Called 3, Confirmed, Canceled
            4 => [5, 6, 7], // Called 3 → Called 4, Confirmed, Canceled
            5 => [7],       // Called 4 → Canceled
            7 => [8, 7],    // Confirmed → Shipping, Canceled
            8 => [9, 10],   // Shipping → Delivered, Returned
            9 => [10],      // Delivered → Paid
            10 => [11],      // Paid → Cash Out
            11 => [12],     // Paid → Cash Out
        ];

        return isset($transitions[$currentStatus]) ? $transitions[$currentStatus] : [];
    }

    
}
