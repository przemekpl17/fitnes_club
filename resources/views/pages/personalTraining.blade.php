@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        jQuery(function($) {
            $(".datepicker").datetimepicker({
                minDate: new Date(),
                language: 'pl'
            });
        });

        $.fn.datetimepicker.dates['pl'] = {
            days: ["Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota"],
            daysShort: ["Niedz.", "Pon.", "Wt.", "Śr.", "Czw.", "Piąt.", "Sob."],
            daysMin: ["Ndz.", "Pn.", "Wt.", "Śr.", "Czw.", "Pt.", "Sob."],
            months: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"],
            monthsShort: ["Sty.", "Lut.", "Mar.", "Kwi.", "Maj", "Cze.", "Lip.", "Sie.", "Wrz.", "Paź.", "Lis.", "Gru."],
            today: "Dzisiaj",
            weekStart: 1,
            clear: "Wyczyść",
            format: "dd.mm.yyyy"
        }
    </script>

    @if(count($trainers) > 0)
        <div class="personal-trainer-container">
            @foreach($trainers as $trainer)
                <div class="personal-trainer-info">
                    <h4>{{ $trainer->name}} {{ $trainer->surname }}</h4>
                    <p>Godzina treningu personalnego:</p>
                    <h3 class="semi-bold">{{ $trainer->training_price }} zł</h3>
                    <p>{{ $trainer->email }}</p>
                    {!! Form::open(['action' => ['PersonalTrainingController@create'], 'method' => 'POST']) !!}
                    {!! Form::label('Wybierz dzień i godzinę:') !!}
                    {{ Form::text('date_time_from', null, ['class' => 'form-control datepicker']) }}
                    <input type="hidden" class="form-control" name="id_client" value="{{$client_info->id_client}}">
                    <input type="hidden" class="form-control" name="id_trainer" value="{{$trainer->id_trainer}}">
                    <input type="hidden" class="form-control" name="training_price" value="{{$trainer->training_price}}">
                    <input type="hidden" class="form-control" name="account_balance" value="{{$client_info->account_balance}}">
                    {{Form::submit('Zapisz się', ['class' => 'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
    @endif
@endsection
