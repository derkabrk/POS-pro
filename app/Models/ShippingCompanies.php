<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompanies extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'contact_number',
        'email',
        'first_r_credential_lable',
        'second_r_credential_lable',
        'create_api_url',
        'update_api_url',
        'delete_api_url',
        'list_api_url',
        'track_api_url',
    ];
}
