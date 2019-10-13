
@extends('layout')

@section('title', 'Nuevo usuario')

@section('content')
    <h1>Crear Usuario</h1>

    <form method="POST" action={{url('usuarios/crear')}}>
        {{csrf_field()}}
        <button type="submit">Crear Usuario</button>
    </form>
    <p><a href="{{route('users.index')}}"> Regresar</a></p>
@endsection
