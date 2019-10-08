@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <h1>{{$title}}</h1>
    @if($users->isEmpty())
        <h2>No hay usuarios registrados</h2>
    @else
        <ul>
            @foreach($users as $user)
                <li>
                    {{$user->name}}
                    <a href="{{route('user.details',['id'=>$user->id])}}">Ver Detalles</a>
                </li>
            @endforeach
        </ul>
     @endif
@endsection
{{--
@section('sidebar')
    @parent

    <h2>Barra lateral personalizada!</h2>
@endsection--}}
