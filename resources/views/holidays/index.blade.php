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
                <div class="card-header">
                    <div class="float-left">{{ __('Listado de vacaciones') }}</div>
                    <div class="float-right">
                        <a href="{{ route('holidays.create') }}" class="btn btn-primary">{{ __('Añadir') }}</a>
                    </div>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>Fecha Inicio</strong></th>
                            <th><strong>Fecha Fin</strong></th>
                            <th><strong>Usuario</strong></th>
                            <th><strong>Tipo de ausencia</strong></th>
                            <th><strong>Estado</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($holidays as $key => $holiday)
                            <tr>    
                                <th>{{$holiday->id}}</th>
                                <th>{{$holiday->start}}</th>
                                <th>{{$holiday->finish}}</th>
                                <th>
                                @foreach($users as $keyUser => $user)
                                    @if ($user->id == $holiday->id_user)
                                        {{$user->name}}
                                    @endif
                                @endforeach
                                </th>
                                <th>
                                @foreach($types as $keyType => $type)
                                    @if ($type->id == $holiday->id_type)
                                        {{$type->name}}
                                    @endif
                                @endforeach
                                </th>
                                <th>{{$holiday->status}}</th>
                                <th>
                                    <form action="{{ route('holidays.destroy',$holiday->id) }}" method="POST">
                                        <a class="btn" href="{{ route('holidays.show',$holiday->id) }}"><i class="fa fa-search" aria-hidden="true"></i></a>
                                        <a class="btn" href="{{ route('holidays.edit',$holiday->id) }}"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
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