@extends('layouts.app')

@section('content')
    <div class="admin-data-container">
        <div class="admin-info">
            <h4>Zalogowany jako:</h4>
            <p>{{$admin->name}}</p>
            <p>email: {{$admin->email}}</p>
        </div>

        <div class="users-operations">
            <h4>Operacje na użytkownikach</h4>
            <a href="/usersList">Zarządzanie użytkownikami</a>
        </div>

        <div class="trainers-operations">
            <h4>Operacje na pracownikach</h4>
            <a href="/trainersList">Zarządzanie trenerami</a>
        </div>

        <div class="activity-operations">
            <h4>Zajęcia grupowe</h4>
            <a href="/activitiesList">Zarządzanie zajęciami grupowymi</a>
        </div>

        <div class="tickets-operations">
            <h4>Karnety</h4>
            <a href="/ticketsList">Karnety zakupione w tym miesiącu</a>
        </div>

        <div class="articles-operations">
            <h4>Aktualności</h4>
            <a href="/articlesList">Zarządzaj aktualnościami</a>
        </div>
    </div>
@endsection
