@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        jQuery(function($) {
            $("#datepicker").datetimepicker({
                minDate: new Date()
            });
        });
    </script>

    @if(count($trainers) > 0)
        <div class="personal-trainer-info">
            @foreach($trainers as $trainer)
                <h4>{{ $trainer->name}} {{ $trainer->surname }}</h4>
                <p>Email:{{ $trainer->email }}</p>
                <p>Cena za trening(1h): {{ $trainer->training_price }} zł</p>
                {!! Form::open(['action' => ['PersonalTrainingController@create'], 'method' => 'POST']) !!}
                {{ Form::text('date_time_from', null, ['class' => 'form-control', 'id'=>'datepicker']) }}
                <input type="hidden" class="form-control" name="id_client" value="{{$client_info->id_client}}">
                <input type="hidden" class="form-control" name="id_trainer" value="{{$trainer->id_trainer}}">
                <input type="hidden" class="form-control" name="training_price" value="{{$trainer->training_price}}">
                <input type="hidden" class="form-control" name="account_balance" value="{{$client_info->account_balance}}">
                {{Form::submit('Zapisz się', ['class' => 'btn btn-primary'])}}
                {!! Form::close() !!}
            @endforeach
        </div>
    @endif

@endsection
