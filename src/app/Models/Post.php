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

    // URL correcta para la imagen principal
    public function getMainImageUrlAttribute()
    {
        $path = public_path($this->main_image);

        if (file_exists($path)) {
            return asset($this->main_image);
        }

        return url('src/public/'.$this->main_image);
    }

    // Devuelve el contenido con URLs correctas para imágenes
    public function getContentWithImageUrlsAttribute()
    {
        $content = $this->content ?? [];

        foreach ($content as &$paragraph) {
            if (!empty($paragraph['image_left'])) {
                $paragraph['image_left_url'] = $this->resolveImageUrl($paragraph['image_left']);
            }
            if (!empty($paragraph['image_right'])) {
                $paragraph['image_right_url'] = $this->resolveImageUrl($paragraph['image_right']);
            }
        }

        return $content;
    }

    // Método privado para resolver la URL de cualquier imagen
    private function resolveImageUrl($relativePath)
    {
        $path = public_path($relativePath);

        if (file_exists($path)) {
            return asset($relativePath);
        }

        return url('src/public/'.$relativePath);
    }
}
