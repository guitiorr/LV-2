<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Engine extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'displacement',
        'cylinder_count',
        'updated_at',
    ];

}
