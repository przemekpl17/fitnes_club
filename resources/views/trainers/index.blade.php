@extends('layouts.app')

@section('content')
    <div class="trainer-data-container">
        <div class="trainer-info">
            <h3>{{$trainer->name}} {{$trainer->surname}}</h3>
            <p>email: {{$user->email}}</p>
            <p>@if(!empty($trainer->training_price)) Cena treningu personalnego: {{$trainer->training_price}} zł @endif</p>
            <a href="/updatePersonalTrainerForm/{{$trainer->id_trainer}}">Uzupełnij swój profil</a>
        </div>

        <div class="trainer-activity">
            <h3>Grafik zajęć</h3>
            <a href="/trainerActivity">Sprawdź grafik na aktualny miesiąc</a>
        </div>

    </div>
@endsection
