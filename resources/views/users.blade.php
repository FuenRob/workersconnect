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
                        <a href="{{ route('new-user') }}" class="btn btn-primary">{{ __('Añadir') }}</a>
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
