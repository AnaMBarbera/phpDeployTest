<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Asumiendo que tienes modelo Post

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('reformas.blog', compact('posts'));
    }

    public function create()
    {
        return view('reformas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'main_image' => 'nullable|image',
            'content.*.text' => 'required|string',
            'content.*.image_left' => 'nullable|image',
            'content.*.image_right' => 'nullable|image',
        ]);
    
        $data = [
            'title' => $request->title,
        ];
    
        // Imagen principal
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('posts', 'public');
        }
    
        $content = [];
        if ($request->has('content')) {
            foreach ($request->content as $para) {
                $paragraph = ['text' => $para['text']];
                // Imagen izquierda
                if (!empty($para['image_left']) && is_file($para['image_left'])) {
                    $paragraph['image_left'] = $para['image_left']->store('posts', 'public');
                } elseif (!empty($para['image_left']) && $para['image_left'] instanceof \Illuminate\Http\UploadedFile) {
                    $paragraph['image_left'] = $para['image_left']->store('posts', 'public');
                }
                // Imagen derecha
                if (!empty($para['image_right']) && is_file($para['image_right'])) {
                    $paragraph['image_right'] = $para['image_right']->store('posts', 'public');
                } elseif (!empty($para['image_right']) && $para['image_right'] instanceof \Illuminate\Http\UploadedFile) {
                    $paragraph['image_right'] = $para['image_right']->store('posts', 'public');
                }
                $content[] = $paragraph;
            }
        }
    
        $data['content'] = $content;
        Post::create($data);
        return redirect()->route('blog.index');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('reformas.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'main_image' => 'nullable|image',
            'content.*.text' => 'required|string',
            'content.*.image_left' => 'nullable|image',
            'content.*.image_right' => 'nullable|image',
        ]);
    
        $data = [
            'title' => $request->title,
        ];
    
        // Imagen principal
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('posts', 'public');
        }
    
        $content = [];
        if ($request->has('content')) {
            foreach ($request->content as $para) {
                $paragraph = ['text' => $para['text']];
                // Imagen izquierda
                if (!empty($para['image_left']) && is_file($para['image_left'])) {
                    $paragraph['image_left'] = $para['image_left']->store('posts', 'public');
                } elseif (!empty($para['image_left']) && $para['image_left'] instanceof \Illuminate\Http\UploadedFile) {
                    $paragraph['image_left'] = $para['image_left']->store('posts', 'public');
                }
                // Imagen derecha
                if (!empty($para['image_right']) && is_file($para['image_right'])) {
                    $paragraph['image_right'] = $para['image_right']->store('posts', 'public');
                } elseif (!empty($para['image_right']) && $para['image_right'] instanceof \Illuminate\Http\UploadedFile) {
                    $paragraph['image_right'] = $para['image_right']->store('posts', 'public');
                }
                $content[] = $paragraph;
            }
        }
    
        $data['content'] = $content;
        $post->update($data);
        return redirect()->route('blog.index');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('reformas.show', compact('post'));
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('blog.index');
    }
}

