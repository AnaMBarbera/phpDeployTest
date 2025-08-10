<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            'content.*.text' => 'string',
            'content.*.image_left' => 'nullable|image',
            'content.*.image_right' => 'nullable|image',
        ]);
    
        $data = [
            'title' => $request->title,
        ];

        // Definir ruta base para guardar imágenes dependiendo del entorno
        $isProduction = app()->environment('production');
        $basePath = $isProduction 
            ? base_path('../posts') // hosting: un nivel arriba de src/public, es decir htdocs/posts
            : public_path('posts');  // local: carpeta public/posts
    
        // Imagen principal
        if ($request->hasFile('main_image')) {
            //  $data['main_image'] = $request->file('main_image')->store('posts', 'public');
            //PARA NO USAR EL LINK DE STORAGE
            $file = $request->file('main_image');
            $fileName = time().'_'.$file->getClientOriginalName();
            //$file->move(public_path('posts'), $fileName);
            $file->move($basePath, $fileName);
            $data['main_image'] = 'posts/'.$fileName; 
        }
    
        $content = [];
        if ($request->has('content')) {
            foreach ($request->content as $para) {
                $paragraph = ['text' => $para['text']];
                if ($request->has('content')) {
                    foreach ($request->content as $index => $para) {
                        $paragraph = ['text' => $para['text']];
                
                        // Imagen izquierda
                        $imageLeftFile = $request->file("image_left_{$index}");
                        if ($imageLeftFile && $imageLeftFile instanceof \Illuminate\Http\UploadedFile) {
                            $fileName = time().'_'.$imageLeftFile->getClientOriginalName();
                            $imageLeftFile->move($basePath, $fileName);
                            $paragraph['image_left'] = 'posts/'.$fileName;
                        }
                
                        // Imagen derecha
                        $imageRightFile = $request->file("image_right_{$index}");
                        if ($imageRightFile && $imageRightFile instanceof \Illuminate\Http\UploadedFile) {
                            $fileName = time().'_'.$imageRightFile->getClientOriginalName();
                            $imageRightFile->move($basePath, $fileName);
                            $paragraph['image_right'] = 'posts/'.$fileName;
                        }
                
                        $content[] = $paragraph;
                    }
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
        $post->content = $post->content_with_image_urls;
        return view('reformas.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'main_image' => 'nullable|image',
            'content.*.text' => 'string',
            'content.*.image_left' => 'nullable|image',
            'content.*.image_right' => 'nullable|image',
        ]);

        $isProduction = app()->environment('production');
        $basePath = $isProduction
            ? base_path('../posts')
            : public_path('posts');

        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $data = [
            'title' => $request->title,
            'main_image' => $post->main_image,
        ];

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $fileName = time() . '_' . Str::random(6) . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($basePath, $fileName);
            $data['main_image'] = 'posts/' . $fileName;
        }

        $oldContent = is_array($post->content) ? $post->content : [];
        $newContent = [];

        if ($request->has('content') && is_array($request->content)) {
            foreach ($request->content as $index => $para) {
                $paragraph = [
                    'text' => $para['text'],
                    'image_left' => $oldContent[$index]['image_left'] ?? null,
                    'image_right' => $oldContent[$index]['image_right'] ?? null,
                ];

                $imageLeftFile = $request->file("image_left_{$index}");
                if ($imageLeftFile && $imageLeftFile instanceof \Illuminate\Http\UploadedFile) {
                    $fileName = time() . '_' . Str::random(6) . '_' . preg_replace('/\s+/', '_', $imageLeftFile->getClientOriginalName());
                    $imageLeftFile->move($basePath, $fileName);
                    $paragraph['image_left'] = 'posts/' . $fileName;
                }

                $imageRightFile = $request->file("image_right_{$index}");
                if ($imageRightFile && $imageRightFile instanceof \Illuminate\Http\UploadedFile) {
                    $fileName = time() . '_' . Str::random(6) . '_' . preg_replace('/\s+/', '_', $imageRightFile->getClientOriginalName());
                    $imageRightFile->move($basePath, $fileName);
                    $paragraph['image_right'] = 'posts/' . $fileName;
                }

                $newContent[] = $paragraph;
            }
        } else {
            $newContent = $oldContent;
        }

        $data['content'] = $newContent;

        $post->update($data);

        return redirect()->route('blog.index');
    }



    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('reformas.show', compact('post'));
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('blog.index');
    }
}

