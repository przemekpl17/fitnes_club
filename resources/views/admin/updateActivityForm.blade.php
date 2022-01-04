@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        jQuery(function($) {
            $("#datePickerFrom").datetimepicker({
                minDate: new Date()
            });

            $("#datePickerTo").datetimepicker({
                minDate: new Date()
            });
        });
    </script>

    {!! Form::open(['action' => ['AdminController@updateActivity', $activity->id_group_activities], 'method' => 'POST']) !!}

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Nazwa zajęcia grupowego')}}
            {{Form::text('name', $activity->name, ['class' => 'form-control', 'placeholder' => 'Nazwa zajęcia grupowego'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Data rozpoczęcia')}}
            {{ Form::text('date_time_from', $activity->date_time_from, ['class' => 'form-control', 'id'=>'datePickerFrom', 'placeholder' => 'Wybierz datę']) }}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Data zakończenia')}}
            {{ Form::text('date_time_to', $activity->date_time_to, ['class' => 'form-control', 'id'=>'datePickerTo', 'placeholder' => 'Wybierz datę']) }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Numer pokoju')}}
            {{Form::number('room_number', $activity->room_number, ['class' => 'form-control', 'placeholder' => 'Numer pokoju'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Maksymalna liczba uczestników')}}
            {{Form::number('max_participants', $activity->max_participants, ['class' => 'form-control', 'placeholder' => 'Maksymalna liczba uczestników'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Trener prowadzący zajęcia')}}
            {{ Form::select('id_trainer',$trainers, $selectedID, ['class'=>'form-control']) }}
        </div>
    </div>


    {{Form::submit('Utwórz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
