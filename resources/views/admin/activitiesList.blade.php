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
                                    <div class="group-activities-col-header">
                                        <p class="week-date">{{$day['full_date']}}</p>
                                        <p class="week-name">{{$day['name_of_day']}}</p>
                                    </div>
                                    @foreach($day['activities'] as $activity)
                                        <div class="activitiesList-col-text">
                                            <h6>{{ $activity->name }}</h6>
                                            <p class="bold">{{$activity->date_time_from->format('H:i')}} - {{$activity->date_time_to->format('H:i')}}</p>
                                            <p>Numer sali: {{$activity->room_number}}</p>
                                            <p>Miejsc: @if(!$activity->enrolled_participants) 0 @else{{$activity->enrolled_participants}}@endif/{{$activity->max_participants}}</p>
                                            <a href="/updateActivityForm/{{$activity->id_group_activities}}" class="btn btn-primary">Edytuj</a>
                                            <a href="/deleteActivity/{{$activity->id_group_activities}}" class="btn btn-danger">Usuń</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
@endsection
