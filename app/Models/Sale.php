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
        'order_source_id',
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

    /**
     * Relationship with the OrderSource model.
     */
    public function orderSource(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class, 'order_source_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure business_id is set before generating the invoice number
            if (empty($model->business_id)) {
                \Log::error('business_id is missing in Sale model:', $model->toArray());
                throw new \Exception('business_id is required to create a Sale.');
            }

            // Generate the invoice number based on the business_id
            $id = Sale::where('business_id', $model->business_id)->count() + 1;
            $model->invoiceNumber = "S" . str_pad($id, 2, '0', STR_PAD_LEFT);
        });

        static::creating(function ($model) {
            // Generate a unique tracking ID
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
        $products = json_decode($value, true) ?? [];
        return array_map(function ($product) {
            return [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
            ];
        }, $products);
    }

    public function setProductsAttribute($value)
    {
        $this->attributes['products'] = json_encode(array_map(function ($product) {
            return [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
            ];
        }, $value));
    }
public const STATUS = [
    1  => ['name' => 'Pending',    'color' => 'btn btn-warning update-status-btn text-white btn-sm me-2 status-update-btn', 'text_color' => '#ffca5b'],  
    2  => ['name' => 'Called 1',   'color' => 'btn btn-info update-status-btn text-white btn-sm me-2 status-update-btn', 'text_color' => '#3fa7d6'],     
    3  => ['name' => 'Called 2',   'color' => 'btn btn-info update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#3fa7d6'],  
    4  => ['name' => 'Called 3',   'color' => 'btn btn-info update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#3fa7d6'],  
    5  => ['name' => 'Called 4',   'color' => 'btn btn-info update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#3fa7d6'],  
    6  => ['name' => 'Canceled',   'color' => 'btn btn-danger update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#ee6352'], 
    7  => ['name' => 'Confirmed',  'color' => 'btn btn-primary update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#8c68cd'], 
    8  => ['name' => 'Shipping',   'color' => 'btn btn-secondary update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#4788ff'],
    9  => ['name' => 'Returned',   'color' => 'btn btn-dark update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#1d2b3a'],
    10 => ['name' => 'Delivered',  'color' => 'btn btn-success update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#40bb82'],  
    11 => ['name' => 'Paid',       'color' => 'btn btn-success update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#40bb82'],
    12 => ['name' => 'Cash Out',   'color' => 'btn btn-primary update-status-btn text-white btn-sm me-2 status-update-btn','text_color' => '#8c68cd'],
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
            7 => [8, 6],    // Confirmed → Shipping, Canceled
            8 => [9, 10],   // Shipping → Delivered, Returned
            9 => [10],      // Delivered → Paid
            10 => [11],      // Paid → Cash Out
            11 => [12],     // Paid → Cash Out
        ];

        return isset($transitions[$currentStatus]) ? $transitions[$currentStatus] : [];
    }

    
}
