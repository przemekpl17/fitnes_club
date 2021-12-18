@extends('layouts.app')

@section('content')

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
            {{Form::number('telephone', $client->telephone, ['class' => 'form-control', 'placeholder' => 'Telefon'])}}
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

        <div class="form-group col-sm-2">
            {{Form::label('title', 'Kod pocztowy')}}
            {{Form::number('post_code', $client->post_code, ['class' => 'form-control', 'placeholder' => 'Kod pocztowy'])}}
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
        <div class="form-group col-sm-2">
            {{Form::label('title', 'Stan konta')}}
            {{Form::number('account_balance', $client->account_balance, ['class' => 'form-control', 'placeholder' => '0'])}}
        </div>
    </div>
{{--    {{Form::hidden('_method', 'PUT')}}--}}
    {{Form::submit('Zapisz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
