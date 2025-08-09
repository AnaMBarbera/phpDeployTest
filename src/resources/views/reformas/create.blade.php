@extends('layouts.app')

@section('title', 'Crear Entrada')

@section('content')
    <h1>Crear nueva entrada</h1>
    @include('reformas.form', [
        'action' => route('blog.store'),
        'method' => 'POST',
        'buttonText' => 'Guardar',
        'post' => null
    ])
    <a href="{{ route('blog.index') }}">Volver</a>
@endsection
