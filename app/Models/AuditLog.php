<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'request_id',
        'user_id',
        'guard',
        'method',
        'path',
        'route_name',
        'action',
        'status_code',
        'ip',
        'user_agent',
        'duration_ms',
        'error_class',
        'error_message',
    ];
}