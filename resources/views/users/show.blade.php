@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detalles del usuario') }}</div>

                <div class="card-body">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-right">{{ __('Nombre y Apellido') }}</label>

                        <div class="col-md-6">
                            <span>{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 text-md-right">{{ __('Correo electrónico') }}</label>

                        <div class="col-md-6">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 text-md-right">{{ __('Contraseña') }}</label>

                        <div class="col-md-6">
                            <span>{{ $user->password }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 text-md-right">{{ __('Confirma la contraseña') }}</label>

                        <div class="col-md-6">
                            <span>{{ $user->password }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_role" class="col-md-4 text-md-right">{{ __('Rol') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($roles as $keyRol => $rol)
                                <span>@if ($rol->id == $user->id_role){{$rol->name}}@endif</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_role" class="col-md-4 text-md-right">{{ __('Compañia') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($companies as $keyCompany => $company)
                                <span>@if ($company->id == $user->id_company){{$company->name}}@endif</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row mb-0">

                        <div class="col-md-2 offset-md-4">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">{{ __('Volver') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
