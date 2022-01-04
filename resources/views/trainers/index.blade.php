@extends('layouts.app')

@section('content')
    <div class="trainer-data-container">
        <div class="trainer-info">
            <img src="" />
            <h3>{{$trainer->name}} {{$trainer->surname}}</h3>
            <p>email: {{$trainer->email}}</p>
            <p>Cena treningu personalnego: {{$trainer->training_price}} zł</p>
        </div>

        <div class="trainer-info">
            <h3>Dane osobowe</h3>
            <a href="/updatePersonalTrainerForm/{{$trainer->id_trainer}}">Uzupełnij swój profil</a>
        </div>

        <div class="trainer-activity">
            <h3>Grafik zajęć</h3>
            <a href="/trainerActivity">Sprawdź</a>
        </div>

    </div>
@endsection
