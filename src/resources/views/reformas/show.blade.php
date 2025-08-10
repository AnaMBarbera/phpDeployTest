@extends('layouts.app')

@section('title', 'Ver Entrada')

@section('content')

    <div class="container">
        <div class="post-main-image" style="position: relative; max-width: 100%; overflow: hidden;">
            @if($post->main_image)
                <img src="{{ asset($post->main_image) }}" alt="Imagen principal">
                <h1 class="post-title">{{ $post->title }}</h1>
            @else
                <h1 class="post-title no-image">{{ $post->title }}</h1>
            @endif
        </div>


        @foreach($post->content as $para)
            <div class="post-paragraph">
                @if(!empty($para['image_left']))
                    <img src="{{ asset($para['image_left']) }}" alt="" class="image-left">
                @endif

                <p class="paragraph-text">{!! nl2br(e($para['text'])) !!}</p>

                @if(!empty($para['image_right']))
                    <img src="{{ asset($para['image_right']) }}" alt="" class="image-right">
                @endif
            </div>
        @endforeach
    </div>

@endsection