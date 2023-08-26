<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrispMessage extends Model
{
    use HasFactory;
    protected $table = 'crisp_messages';
    protected $fillable = [
        "website_id",
        "fingerprint",
        "session_id",
        "name",
        "from",
        "content",
        "user",
        "stamped",
    ];



    protected $casts = [
        'user' => 'json',
        'stamped' => 'boolean'
    ];
}