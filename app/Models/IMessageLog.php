<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_status',
        'from',
        'to',
        'message_status',
        'ref_no',
        'error_code',
        'error_message',
        'remark'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
