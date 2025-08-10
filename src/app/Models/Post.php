<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'main_image', 'content'];

    protected $casts = [
        'content' => 'array',
    ];

    public function getMainImageUrlAttribute()
    {
        if (!$this->main_image) {
            return null;
        }

        $relativePath = $this->main_image;

        // Aseguramos que empieza por posts/
        if (!str_starts_with($relativePath, 'posts/')) {
            $relativePath = 'posts/' . $relativePath;
        }

        // Asumimos que siempre está accesible desde public/posts
        return asset($relativePath);
    }

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

    private function resolveImageUrl($relativePath)
    {
        if (!str_starts_with($relativePath, 'posts/')) {
            $relativePath = 'posts/' . $relativePath;
        }

        return asset($relativePath);
    }
}

