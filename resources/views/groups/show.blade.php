@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Detalles del grupo') }}</div>

                <div class="card-body">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <span>{{ $group->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 text-md-right">{{ __('Descripción') }}</label>

                        <div class="col-md-6">
                            <span>{{ $group->description }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_role" class="col-md-4 text-md-right">{{ __('Equipo') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($teams as $keyTeam => $team)
                                <span>@if ($team->id == $group->id_team){{$team->name}}@endif</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_role" class="col-md-4 text-md-right">{{ __('Compañia') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($companies as $keyCompany => $company)
                                <span>@if ($company->id == $group->id_company){{$company->name}}@endif</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="participant" class="col-md-4 text-md-right">{{ __('Participantes') }}</label>
                        
                        <div class="col-md-6">
                            @foreach($usersInGroup as $keyUser => $user)
                                <span>{{$user->name}}</span><br/>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row mb-0">

                        <div class="col-md-2 offset-md-4">
                            <a href="{{ route('groups.index') }}" class="btn btn-primary">{{ __('Volver') }}</a>
                        </div>
                        @if($userFollowGroup)
                            <div class="col-md-2 offset-md-4">
                                <a href="/unfollow-group/{{ $group->id }}" class="btn btn-primary">{{ __('Dejar de seguir') }}</a>
                            </div>
                        @else
                            <div class="col-md-2 offset-md-4">
                                <a href="/follow-group/{{ $group->id }}" class="btn btn-primary">{{ __('Seguir') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
