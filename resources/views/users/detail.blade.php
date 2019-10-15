@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <ul>

            <li>Nombre: {{$user->name}} </li>
            <li>Email: {{$user->email}} </li>
            <li>Profesion: {{$user->profession->title}}</li>

    </ul>
    {{csrf_field()}}

    <form method="POST" action="{{route('borrar',$user)}}">
        {{csrf_field()}}
        {{method_field('DELETE')}}
        <div>
            <a href="{{url("usuarios/$user->id/editar")}}" class="btn btn-warning" tabindex="-1" role="button">Editar</a>
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="{{route('users.index')}}" class="btn btn-dark"> Regresar</a>
        </div>

    </form>


@endsection
