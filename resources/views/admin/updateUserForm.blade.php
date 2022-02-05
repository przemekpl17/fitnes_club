@extends('layouts.app')

@section('content')
    <a href="/usersList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => ['AdminController@updateUser', $client->id_client, $user[0]->id_users], 'method' => 'POST']) !!}
        <h4>Dane rejestracji</h4>

        <div class="form-row">
            <div class="form-group col-md-6">
                {{Form::label('title', 'Nazwa użytkownika')}}
                {{Form::text('name', $user[0]->name, ['class' => 'form-control', 'placeholder' => 'Nazwa użytkownika'])}}
            </div>

            <div class="form-group col-md-6">
                {{Form::label('title', 'Adres email')}}
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
                {{Form::text('client_name', $client->name, ['class' => 'form-control', 'placeholder' => 'Imię'])}}
            </div>

            <div class="form-group col-md-6">
                {{Form::label('title', 'Nazwisko')}}
                {{Form::text('surname', $client->surname, ['class' => 'form-control', 'placeholder' => 'Nazwisko'])}}
            </div>

            <div class="form-group col-md-6">
                {{Form::label('title', 'Telefon')}}
                {{Form::number('telephone', $client->telephone, ['class' => 'form-control', 'placeholder' => 'Telefon'])}}
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                {{Form::label('title', 'Miasto')}}
                {{Form::text('city', $client->city, ['class' => 'form-control', 'placeholder' => 'Miasto'])}}
            </div>

            <div class="form-group col-md-3">
                {{Form::label('title', 'Ulica')}}
                {{Form::text('street', $client->street, ['class' => 'form-control', 'placeholder' => 'Ulica'])}}
            </div>

            <div class="form-group col-xs-2">
                {{Form::label('title', 'Numer')}}
                {{Form::number('street_number', $client->street_number, ['class' => 'form-control', 'placeholder' => 'Numer'])}}
            </div>

            <div class="form-group col-sm-2">
                {{Form::label('title', 'Kod pocztowy')}}
                {{Form::text('post_code', $client->post_code, ['class' => 'form-control', 'placeholder' => 'Kod pocztowy'])}}
            </div>

            <div class="col-md-12">
                {{Form::label('title', 'Płeć')}}
                <div class="form-check">
                    <input type="radio" class="flat" name="gender"  value="m"
                        {{ $client->gender == 'm' ? 'checked' : '' }}>
                    <label class="form-check-label">Mężczyzna</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="flat" name="gender"  value="k"
                        {{ $client->gender == 'k' ? 'checked' : '' }}>
                    <label class="form-check-label">Kobieta</label>
                </div>
            </div>
        </div>

    {{Form::submit('Zapisz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
