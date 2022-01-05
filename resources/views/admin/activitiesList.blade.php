@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="add-activity">
            <a href="/admin" class="btn btn-primary">Powrót</a>
            <a href="/addActivityForm" class="btn btn-primary">Dodaj zajęcie grupowe</a>
        </div>
        <div class="group-activities-content">
            <div class="swiper mySwiper ">
                <div class="swiper-wrapper ">
                    @foreach ($daysOfMonth as $key => $dayOfMonth)
                        <div class="swiper-slide group-activities-content init-slide='3'">
                            @foreach($dayOfMonth as $key => $day)
                                <div class="group-activities-col">
                                    <h4>{{$day['full_date']}}</h4>
                                    <h4>{{$day['name_of_day']}}</h4>
                                    @foreach($day['activities'] as $activity)
                                        <div class="group-activities-col-text">
                                            <h5>{{ $activity->name }}</h5>
                                            <h5>{{$activity->date_time_from->format('H:i')}} - {{$activity->date_time_to->format('H:i')}}</h5>
                                            <p>Numer sali: {{$activity->room_number}}</p>
                                            <p>Maksymalna liczba uczestników: {{$activity->max_participants}}</p>
                                            <a href="/updateActivityForm/{{$activity->id_group_activities}}" class="btn btn-primary">Edytuj</a>
                                            <a href="/deleteActivity/{{$activity->id_group_activities}}" class="btn btn-danger">Usuń</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
@endsection
