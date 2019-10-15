@extends('layout')

@section('title', 'Usuarios')

@section('content')
    <h1>{{$title}}</h1>
    @if($users->isEmpty())
        <h2>No hay usuarios registrados</h2>
    @else
        {{--<ul>
            @foreach($users as $user)
                <li>
                    {{$user->name}}

                    <div>
                        <a href="{{route('users.details',['id'=>$user->id])}}" class="btn btn-success">Ver Detalles</a>
                        <a href="{{url("usuarios/$user->id/editar")}}" class="btn btn-warning" tabindex="-1" role="button">Editar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </li>
            @endforeach
        </ul>--}}

        <div class="list-group">
            @foreach($users as $user)
                <a href="{{route('users.details',['id'=>$user->id])}}" class="list-group-item list-group-item-action">{{$user->name}}</a>
            @endforeach
        </div>
     @endif
@endsection
{{--
@section('sidebar')
    @parent

    <h2>Barra lateral personalizada!</h2>
@endsection--}}
