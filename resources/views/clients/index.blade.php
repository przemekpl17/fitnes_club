@extends('layouts.app')

@section('content')
    <div class="user-data-container">

        <div class="user-avatar">
            <img src="" />
            <h3>{{$client->name}} {{$client->surname}}</h3>
            <p>tel: {{$client->telephone}}</p>
            <p>email: {{$client->email}}</p>
            <p>Stan konta: {{$client->account_balance}} zł</p>
        </div>

        <div class="user-info">
            <h3>Dane osobowe</h3>
            <a href="/clientUpdate">Uzupełnij swój profil</a>
        </div>

        <div class="user-calendar">
            <h3>Dzienniczek aktywności</h3>
            <a href="/clientActivity">Sprawdź swoje aktywności</a>
        </div>

        <div class="user-ticket">
            <h3>Mój karnet</h3>
            <h4>Rodzaj: {{$ticket->type}}</h4>
            <p>ważny do: {{$ticket->date_to->format('d.m.Y')}}</p>
        </div>

        <div class="user-trainer">
            <h3>Mój trener</h3>
            <h4>Imie trenera Nazwisko trenera</h4>
            <p>Pozostało ci treningów personalnych: 5</p>
        </div>
    </div>
@endsection
