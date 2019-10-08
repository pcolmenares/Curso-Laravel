@extends('layout')

@section('title', "Usuario {$user->id}")

@section('content')
    <ul>

            <li>Nombre: {{$user->name}} </li>
            <li>Email: {{$user->email}} </li>
            <li>Profesion: {{$user->profession->title}}</li>

    </ul>
    <p><a href="{{route('user.index')}}"> Regresar</a></p>
@endsection
