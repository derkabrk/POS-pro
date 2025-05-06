<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicApiHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',          // Name of the API header (e.g., Facebook Pixel)
        'api_key',       // API key or Pixel ID
        'status',        // Active or Inactive
        'description',   // Optional description
    ];
}