<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'main_image', 'content'];

    // Para que Laravel convierta content automáticamente a array y viceversa
    protected $casts = [
        'content' => 'array',
    ];
}
