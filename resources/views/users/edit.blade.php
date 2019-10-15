
@extends('layout')

@section('title', 'Editar usuario')

@section('content')
    <h1>Editar usuario</h1>

    <form method="POST" action={{url("/usuarios/$user->id")}} class="needs-validation" novalidate>
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="form-group ">
            <label for="name">Nombre:</label>
            @php
                $invalidName='';
            @endphp
            @if($errors->has('name'))
                @php
                    $invalidName='is-invalid';
                @endphp
            @endif
            <input type="text" name="name" class="form-control {{$invalidName}}" id="name"  placeholder="Enter name" required value="{{old('name',$user->name)}}">
            <div class="invalid-feedback">
                Por favor ingrese un nombre valido.
            </div>
        </div>
        <div class="form-group">
            @php
                $invalidEmail='';
            @endphp
            @if($errors->has('email'))
                @php
                    $invalidEmail='is-invalid';
                @endphp
            @endif
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control {{$invalidEmail}}" id="email"  placeholder="Enter email" required  value="{{old('email',$user->email)}}">
            <div class="invalid-feedback">
                @if($errors->has('email'))
                    {{$errors->first('email') }}
                @else
                    Por favor ingrese un email valido.
                @endif
            </div>
        </div>
        <div class="form-group">
            @php
                $invalidPass='';
            @endphp
            @if($errors->has('password'))
                @php
                    $invalidPass='is-invalid';
                @endphp
            @endif
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control {{$invalidPass}}" id="password" placeholder="Password" >
            <div class="invalid-feedback">
                @if($errors->has('password'))
                    {{$errors->first('password') }}
                @else
                    Por favor ingrese un password valido.
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="profession">Profession:</label>
            <select name="profession" id="profession" class="form-control form-control-lg" required>
                <option value="">Seleccione una profesion</option>
                @foreach($professions as $profession)
                    <option value="{{$profession->id}}"  {{ $profession->id == $user->profession_id ? 'selected' : '' }}>{{$profession->title}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor seleccione una profesion.
            </div>

        </div>
        <div>
            </p><button type="submit" class="btn btn-primary">Editar Usuario</button>
        </div>
    </form>
        <div>


            <form method="POST" action="{{route('borrar',$user)}}">
                {{csrf_field()}}
                {{method_field('DELETE')}}

                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="{{route('users.index')}}" class="btn btn-dark"> Regresar</a>
            </form>

        </div>




    <script src="{{asset('js/proyecto.js')}}"></script>

@endsection
