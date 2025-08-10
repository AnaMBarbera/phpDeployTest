@extends('layouts.app')

@section('title', 'Blog')

@section('content')
    <div class="container">
        <h1>Entradas del Blog</h1>
        <a href="{{ route('blog.create') }}" class="button">Nueva Entrada</a>
        <br><br>
        <ul class="blog-list">
            @foreach($posts as $post)
                <li class="blog-card">
                    <!-- Enlace al show -->
                    @if($post->main_image_url)
                        <img src="{{ $post->main_image_url }}" alt="Imagen principal" class="main-image">
                    @endif
                    <div class="blog-content">
                        <a href="{{ route('blog.show', $post->id) }}" class="blog-title">{{ $post->title }}</a>
                        <p class="blog-excerpt">{{ Str::limit(strip_tags($post->content[0]['text'] ?? ''), 150) }}</p>
                        
                        <div class="blog-actions">
                            <!-- Botón para editar -->
                            <a href="{{ route('blog.edit', $post->id) }}" class="button edit">Editar</a>

                            <form action="{{ route('blog.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Borrar esta entrada?')" class=" delete">Borrar</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
