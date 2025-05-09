<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color'];
    protected $table = 'ticket_categories';
    /**
     * Define the relationship with the TicketSystem model.
     */
    public function tickets()
    {
        return $this->hasMany(TicketSystem::class, 'category_id');
    }
     
}