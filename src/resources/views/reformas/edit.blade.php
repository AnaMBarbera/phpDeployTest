@extends('layouts.app')

@section('title', 'Editar Entrada')

@section('content')
    <h1>Editar entrada</h1>
    @include('reformas.form', [
        'action' => route('blog.update', ['blog' => $post->id]),
        'method' => 'PUT',
        'buttonText' => 'Actualizar',
        'post' => $post
    ])
    <a href="{{ route('blog.index') }}">Volver</a>
@endsection
