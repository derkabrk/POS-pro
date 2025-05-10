<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'email',
        'status_id',
        'priority',
        'category_id',
        'business_id',
    ];

    /**
     * Define the relationship with the TicketCategories model.
     */
    public function category()
    {
        return $this->belongsTo(TicketCategories::class, 'category_id');
    }

    /**
     * Define the relationship with the TicketStatus model.
     */
    public function status()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }
}