@extends('layouts.app')

@section('content')
    <div class="admin-data-container">
        <div class="admin-info">
            <img src="" />
            <h3>{{$admin->name}}</h3>
            <p>email: {{$admin->email}}</p>
        </div>

        <div class="users-operations">
            <h3>Operacje na użytkownikach</h3>
            <a href="/usersList">Zarządzanie użytkownikami</a>
        </div>

        <div class="trainers-operations">
            <h3>Operacje na pracownikach</h3>
            <a href="/trainersList">Zarządzanie trenerami</a>
        </div>

        <div class="activity-operations">
            <h3>Zajęcia grupowe</h3>
            <a href="/activitiesList">Zarządzanie zajęciami grupowymi</a>
        </div>

        <div class="tickets-operations">
            <h3>Karnety</h3>
            <a href="/ticketsList">Karnety zakupione w tym miesiącu</a>
        </div>

        <div class="articles-operations">
            <h3>Aktualności</h3>
            <a href="/articlesList">Zarządzaj aktualnościami</a>
        </div>
    </div>
@endsection
