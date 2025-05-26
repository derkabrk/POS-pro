<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_id',
        'name',
        'role',
        'email',
        'phone',
        'image',
        'lang',
        'password',
        'visibility',
        'remember_token',
        'email_verified_at',
        'plan_id', // add this line
        'plan_permissions', // add this line
        'points', // add this line for invite/referral points
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'visibility' => 'json',
        'email_verified_at' => 'datetime',
        'plan_permissions' => 'json', // add this line
    ];

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class, 'plan_id');
    }

    public function hasPlanPermission($permission)
    {
        $permissions = $this->plan_permissions;
        if (empty($permissions) && $this->plan) {
            $permissions = $this->plan->permissions;
        }
        if (is_array($permissions)) {
            return in_array($permission, $permissions);
        }
        return false;
    }

    public function unreadMessagesCount()
    {
        // Count unread messages for the current user
        return \App\Models\Chat::where('receiver_id', $this->id)
            ->whereNull('read_at')
            ->count();
    }
}
