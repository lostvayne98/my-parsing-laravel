<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_method',
        'request_url',
        'response_http_code',
        'response_body',
        'time_end'
    ];
}
