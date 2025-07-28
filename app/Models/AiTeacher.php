<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'persona_id',
        'description',
        'avatar_url',
    ];
}
