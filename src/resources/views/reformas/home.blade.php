@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <h1>Bienvenido a la página de inicio</h1>
    <a href="{{ route('blog.index') }}">Ir al Blog</a>
@endsection
