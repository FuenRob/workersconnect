@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card-header">{{ __('Nuevas vacaciones') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('holidays.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="id_type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de ausencia') }}</label>
                            
                            <div class="col-md-6">
                                @foreach($types as $keyType => $type)
                                    <span>@if ($holiday->id_type == $type->id){{$type->name}}@endif</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }}</label>

                            <div class="col-md-6">
                                <span>{{ $holiday->start }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="finish" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Fin') }}</label>

                            <div class="col-md-6">
                                <span>{{ $holiday->finish }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="finish" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>

                            <div class="col-md-6">
                                <span>{{ $holiday->status }}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reponsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsables de la petición') }}</label>

                            <div class="col-md-6">
                                <div class="row">
                                    @foreach($userResponsables as $keyUserResponsables => $userResponsable)
                                        @if($userResponsable->id === $user->id)
                                            <div class="col-md-6">
                                                <span>{{$userResponsable->name}}</span>
                                            </div>
                                            <div class="col-md-6">
                                                @if($userResponsable->accepted == 0 && $holiday->status == "pending")
                                                    <a class="btn" href="/holiday/accept/{{ $holiday->id }}"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    <a class="btn" href="/holiday/decline/{{ $holiday->id }}"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                                @elseif($userResponsable->accepted == 0)
                                                    <span>{{ __('Ya las rechazaste') }}</span>
                                                @else
                                                    <span>{{ __('Ya las aceptaste') }}</span>
                                                @endif
                                            </div>
                                        @else 
                                            <div class="col-md-12">
                                                <span>{{$userResponsable->name}}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <a href="/holidays" class="btn btn-primary">{{ __('Volver') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
