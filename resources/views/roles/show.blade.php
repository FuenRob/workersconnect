@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('DEtalles del rol') }}</div>

                <div class="card-body">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 text-md-right">{{ __('Rol') }}</label>

                        <div class="col-md-6">
                            <span>{{ $role->name }}</span>
                        </div>
                    </div>

                    <div class="form-group row mb-0">

                        <div class="col-md-2 offset-md-4">
                            <a href="{{ route('roles.index') }}" class="btn btn-primary">{{ __('Volver') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
