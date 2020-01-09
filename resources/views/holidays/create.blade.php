@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Nuevas vacaciones') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('holidays.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="id_type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de ausencia') }}</label>
                            
                            <div class="col-md-6">
                                <select class="form-control" name="id_type" id="id_type">
                                @foreach($types as $keyType => $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio') }}</label>

                            <div class="col-md-6">
                                <input id="start" type="text" class="form-control datepicker @error('start') is-invalid @enderror" name="start" value="{{ old('start') }}" required autocomplete="start" autofocus>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                                @error('start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="finish" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Fin') }}</label>

                            <div class="col-md-6">
                                <input id="finish" type="text" class="form-control datepicker @error('finish') is-invalid @enderror" name="finish" value="{{ old('finish') }}" required autocomplete="finish" autofocus>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>

                                @error('finish')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="id_company" type="hidden" class="form-control" name="id_company" value="{{ $user->id_company }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reponsable" class="col-md-4 col-form-label text-md-right">{{ __('Indica quien debe validar tu petición') }}</label>

                            <div class="col-md-6 autocomplete">
                                <input id="reponsable" type="text" class="form-control tm-input @error('reponsable') is-invalid @enderror" name="reponsable" value="{{ old('reponsable') }}" autocomplete="reponsable" autofocus>

                                @error('reponsable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        // Input with datepicket format
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'mm/dd/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $('.datepicker').datepicker({  
                format: 'mm-dd-yyyy'
            },
        );

        // Ajax for get user in autocomplete Responsable's field form
        var tagApi = $(".tm-input").tagsManager();
        $('#reponsable').typeahead({
            name: 'tags',
            displayKey: 'name',
            source:  function (request, process) {
                return $.get("{{url('get-users')}}", { term: request.term }, function (data) {
                    console.log(data);
                    return process(data);
                });
            },
            afterSelect :function (item){
                tagApi.tagsManager("pushTag", item.email);
            }
        });
    });

</script> 
@endsection
