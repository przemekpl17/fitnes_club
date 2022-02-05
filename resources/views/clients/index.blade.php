@extends('layouts.app')

@section('content')
    <div class="user-data-container">

        <div class="user-avatar">
            <h3>@if(!empty($client->name || $client->surname)){{$client->name}} {{$client->surname}}@endif</h3>
            <p>@if(!empty($client->telephone)) tel: {{$client->telephone}}@endif</p>
            <p>email: {{$client->email}}</p>
            <p>@if(!empty($client->account_balance))Stan konta: {{$client->account_balance}} zł @endif</p>
            <a href="/clientUpdate/{{$client->id_client}}">Uzupełnij swój profil</a>
        </div>

        <div class="user-calendar">
            <h3>Dzienniczek aktywności</h3>
            <a href="/clientActivity">Sprawdź swoje aktywności</a>
        </div>

        <div class="user-ticket">
            <h3>Mój karnet</h3>
            @if(empty($ticket))
                <p>Nie posiadasz karnetu.</p>
            @else
                <p>Rodzaj: {{$ticket->type}}</p>
                <p class="semi-bold">ważny do: {{$ticket->date_to->format('d.m.Y')}}</p>
            @endif
        </div>
    </div>
@endsection
