@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-header">
                    <div class="float-left">{{ __('Listado de usuarios') }}</div>
                    <div class="float-right">
                        <a href="{{ route('users.create') }}" class="btn btn-primary">{{ __('Añadir') }}</a>
                    </div>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>Nombre</strong></th>
                            <th><strong>Correo Electrónico</strong></th>
                            <th><strong>Rol</strong></th>
                            <th><strong>Acciones</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>    
                                <th>{{$user->id}}</th>
                                <th>{{$user->name}}</th>
                                <th>{{$user->email}}</th>
                                <th>
                                @foreach($roles as $keyRol => $rol)
                                    @if ($rol->id == $user->id_role)
                                        {{$rol->name}}
                                    @endif
                                @endforeach
                                </th>
                                <th>
                                    <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection