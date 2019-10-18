@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Detalles del equipo') }}</div>

                <div class="card-body">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <span>{{ $team->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_role" class="col-md-4 text-md-right">{{ __('Compañia') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($companies as $keyCompany => $company)
                                <span>@if ($company->id == $team->id_company){{$company->name}}@endif</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="participant" class="col-md-4 text-md-right">{{ __('Integrantes') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($usersInTeam as $keyUser => $user)
                                <span>{{$user->name}}</span><br/>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row mb-0">

                        <div class="col-md-2 offset-md-4">
                            <a href="{{ route('teams.index') }}" class="btn btn-primary">{{ __('Volver') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
