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
        'status', // e.g., Open, Closed, Pending
        'priority', // e.g., Low, Medium, High
        'assigned_to', // User ID of the assigned person
        'created_by', // User ID of the creator
        'category_id', // Foreign key for TicketCategories
    ];

    /**
     * Define the relationship with the TicketCategories model.
     */
    public function category()
    {
        return $this->belongsTo(TicketCategories::class, 'category_id');
    }
}