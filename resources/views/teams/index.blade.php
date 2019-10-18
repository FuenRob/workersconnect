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
                    <div class="float-left">{{ __('Listado de equipos') }}</div>
                    <div class="float-right">
                        <a href="{{ route('teams.create') }}" class="btn btn-primary">{{ __('Añadir') }}</a>
                    </div>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                        <tr>
                            <th><strong>ID</strong></th>
                            <th><strong>Nombre</strong></th>
                            <th><strong>Compañia</strong></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teams as $key => $team)
                            <tr>    
                                <th>{{$team->id}}</th>
                                <th>{{$team->name}}</th>
                                <th>
                                @foreach($companies as $keyCompany => $company)
                                    @if ($company->id == $team->id_company)
                                        {{$company->name}}
                                    @endif
                                @endforeach
                                </th>
                                <th>
                                    <form action="{{ route('teams.destroy',$team->id) }}" method="POST">
                                        <a class="btn" href="{{ route('teams.show',$team->id) }}"><i class="fa fa-search" aria-hidden="true"></i></a>
                                        <a class="btn" href="{{ route('teams.edit',$team->id) }}"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
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