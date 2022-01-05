@extends('layouts.app')

@section('content')

    <a href="/trainersList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => 'AdminController@createTrainer', 'method' => 'POST']) !!}

    <h4>Dane do rejestracji</h4>

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Nazwa użytkownika')}}
            {{Form::text('name','', ['class' => 'form-control', 'placeholder' => 'Nazwa użytkownika'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Adres email')}}
            {{Form::text('email','', ['class' => 'form-control', 'placeholder' => 'Adres email'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Hasło')}}
            {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Hasło'])}}
        </div>
    </div>

    <h4>Dane osobowe</h4>

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Imię')}}
            {{Form::text('trainer_name','', ['class' => 'form-control', 'placeholder' => 'Imię'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Nazwisko')}}
            {{Form::text('surname','', ['class' => 'form-control', 'placeholder' => 'Nazwisko'])}}
        </div>

{{--        <div class="form-group col-md-6">--}}
{{--            {{Form::label('title', 'Email')}}--}}
{{--            {{Form::email('email','', ['class' => 'form-control', 'placeholder' => 'Email'])}}--}}
{{--        </div>--}}

{{--        <div class="form-group col-md-6">--}}
{{--            {{Form::label('title', 'Telefon')}}--}}
{{--            {{Form::number('telephone','', ['class' => 'form-control', 'placeholder' => 'Telefon'])}}--}}
{{--        </div>--}}
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {{Form::label('title', 'Miasto')}}
            {{Form::text('city','', ['class' => 'form-control', 'placeholder' => 'Miasto'])}}
        </div>

        <div class="form-group col-md-4">
            {{Form::label('title', 'Ulica')}}
            {{Form::text('street','', ['class' => 'form-control', 'placeholder' => 'Ulica'])}}
        </div>

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Numer')}}
            {{Form::number('street_number','', ['class' => 'form-control', 'placeholder' => 'Numer'])}}
        </div>

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Kod pocztowy')}}
            {{Form::text('post_code','', ['class' => 'form-control', 'placeholder' => 'Kod pocztowy'])}}
        </div>

        <div class="col-md-6">
            {{Form::label('title', 'Płeć')}}
            <div class="form-check">
                {{Form::radio('gender','m',['class'=> 'form-check-input'])}}
                {{Form::label('title', 'Mężczyzna')}}
            </div>
            <div class="form-check">
                {{Form::radio('gender','k',['class'=> 'form-check-input'])}}
                {{Form::label('title', 'Kobieta')}}
            </div>

        </div>
    </div>

    {{Form::submit('Utwórz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
