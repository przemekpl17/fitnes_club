@extends('layouts.app')

@section('content')
    <a href="/trainersList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => ['AdminController@updateTrainer', $trainer->id_trainer, $user[0]->id_users], 'method' => 'POST']) !!}
    <h4>Dane rejestracji</h4>
    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Nowa nazwa użytkownika')}}
            {{Form::text('name', $user[0]->name, ['class' => 'form-control', 'placeholder' => 'Nazwa użytkownika'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Nowy adres email')}}
            {{Form::text('email', $user[0]->email, ['class' => 'form-control', 'placeholder' => 'Nowy adres email'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Nowe hasło')}}
            {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nowe hasło'])}}
        </div>
    </div>

    <h4>Dane użytkownika</h4>

    <div class="form-row">
        <div class="form-group col-md-6">

            {{Form::label('title', 'Imię')}}
            {{Form::text('trainer_name', $trainer->name, ['class' => 'form-control', 'placeholder' => 'Imię'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Nazwisko')}}
            {{Form::text('surname', $trainer->surname, ['class' => 'form-control', 'placeholder' => 'Nazwisko'])}}
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {{Form::label('title', 'Miasto')}}
            {{Form::text('city', $trainer->city, ['class' => 'form-control', 'placeholder' => 'Miasto'])}}
        </div>

        <div class="form-group col-md-4">
            {{Form::label('title', 'Ulica')}}
            {{Form::text('street', $trainer->street, ['class' => 'form-control', 'placeholder' => 'Ulica'])}}
        </div>

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Numer')}}
            {{Form::number('street_number', $trainer->street_num, ['class' => 'form-control', 'placeholder' => 'Numer'])}}
        </div>

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Kod pocztowy')}}
            {{Form::text('post_code', $trainer->post_code, ['class' => 'form-control', 'placeholder' => 'Kod pocztowy'])}}
        </div>

        <div class="col-md-6">
            {{Form::label('title', 'Płeć')}}
            <div class="form-check">
                <input type="radio" class="flat" name="gender"  value="m"
                    {{ $trainer->gender == 'm' ? 'checked' : '' }}>
                <label class="form-check-label">Mężczyzna</label>
            </div>
            <div class="form-check">
                <input type="radio" class="flat" name="gender"  value="k"
                    {{ $trainer->gender == 'k' ? 'checked' : '' }}>
                <label class="form-check-label">Kobieta</label>
            </div>
        </div>

    </div>
    {{--    {{Form::hidden('_method', 'PUT')}}--}}
    {{Form::submit('Zapisz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
