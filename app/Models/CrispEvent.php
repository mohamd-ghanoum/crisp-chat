<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrispEvent extends Model
{
    use HasFactory;
    protected $table = 'crisp_event';
    protected $fillable = [
        "name",
        "user_id",
        "meta"
    ];


    protected $casts = [
        'meta' => 'json'
    ];
}