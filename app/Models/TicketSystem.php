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
        'assign_to', // Add this field
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

    /**
     * Define the relationship with the User model for assigned user.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    /**
     * Define the relationship with the User model for the ticket creator.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with the TicketReply model.
     */
    public function replies()
    {
        return $this->hasMany(\App\Models\TicketReply::class, 'ticket_id');
    }
}