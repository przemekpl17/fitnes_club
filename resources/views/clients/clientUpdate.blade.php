@extends('layouts.app')

@section('content')
    <a href="/client" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => ['ClientsController@update', $client->id_client], 'method' => 'POST']) !!}
    <div class="form-row">
         <div class="form-group col-md-6">

            {{Form::label('title', 'Imię')}}
            {{Form::text('name', $client->name, ['class' => 'form-control', 'placeholder' => 'Imię'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Nazwisko')}}
            {{Form::text('surname', $client->surname, ['class' => 'form-control', 'placeholder' => 'Nazwisko'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Email')}}
            {{Form::email('email', $client->email, ['class' => 'form-control', 'placeholder' => 'Email'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Telefon')}}
            {{Form::number('telefon', $client->telephone, ['class' => 'form-control', 'placeholder' => 'Telefon komórkowy'])}}
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            {{Form::label('title', 'Miasto')}}
            {{Form::text('city', $client->city, ['class' => 'form-control', 'placeholder' => 'Miasto'])}}
        </div>

        <div class="form-group col-md-4">
            {{Form::label('title', 'Ulica')}}
            {{Form::text('street', $client->street, ['class' => 'form-control', 'placeholder' => 'Ulica'])}}
        </div>

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Numer')}}
            {{Form::number('street_number', $client->street_number, ['class' => 'form-control', 'placeholder' => 'Numer'])}}
        </div>

        <div class="form-group col-sm-3">
            {{Form::label('title', 'Kod pocztowy')}}
            {{Form::text('post_code', $client->post_code, ['class' => 'form-control', 'placeholder' => 'Kod pocztowy'])}}
        </div>

        <div class="form-group col-sm-3">
            {{Form::label('title', 'Stan konta')}}
            {{Form::number('account_balance', $client->account_balance, ['class' => 'form-control', 'placeholder' => '0'])}}
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
