<?php

namespace Modules\Business\App\Models;

use Illuminate\Database\Eloquent\Model;

class SentBulkMessage extends Model
{
    protected $table = 'sent_bulk_messages';
    protected $guarded = [];
    protected $casts = [
        'results' => 'array',
    ];
}
