<?php

namespace Modules\Business\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InviteCode extends Model
{
    protected $fillable = [
        'code',
        'used',
        'used_by',
        'expires_at',
        'created_by', // add this for tracking inviter
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public static function generateUniqueCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());
        return $code;
    }
}
