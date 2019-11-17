@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Editar grupo') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('groups.update',$group->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $group->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>
                            <div class="col-md-6">
                                <textarea rows="4" cols="54" id="description" name="description">{{ $group->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_team" class="col-md-4 col-form-label text-md-right">{{ __('Equipo') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control" name="id_team" id="id_team">
                                @foreach($teams as $keyTeam => $team)
                                    <option value="{{$team->id}}" @if ($team->id == $group->id_team) selected @endif>{{$team->name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="{{ $group->id_company }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Actualizar') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">{{ __('Volver') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
