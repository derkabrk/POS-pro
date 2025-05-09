<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $fillable = ['name', 'color'];
    protected $table = 'ticket_statuses';

    public function tickets()
    {
        return $this->hasMany(TicketSystem::class, 'status_id');
    }
}