@extends('layouts.app')

@section('content')
        <a href="/client" class="btn btn-primary">Powrót</a>
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
                                            <div class="group-activities-col-text">
                                                <h6 class="border-bottom">Zajęcie grupowe</h6>
                                                <p>{{ $activity->name }}</p>
                                                <p class="semi-bold">{{ \Carbon\Carbon::parse($activity->date_time_from)->format('H:i') }} - {{ \Carbon\Carbon::parse($activity->date_time_to)->format('H:i') }}</p>
                                                <p>Numer sali: {{$activity->room_number}}</p>
                                                    {!! Form::open(['action' => ['Clients_GroupActivitiesController@deleteUserActivity', $activity->id_client_group_activities], 'method' => 'POST']) !!}
                                                    <input type="hidden" class="form-control" name="id_activity" value="{{$activity->id_group_activities}}">
                                                    <input type="hidden" class="form-control" name="id_client" value="{{$id_client}}">
                                                    {{Form::submit('Wypisz się', ['class' => 'btn btn-danger'])}}
                                                    {!! Form::close() !!}
                                            </div>
                                        @endforeach
                                        @foreach($day['personal_training'] as $personalTraining)
                                            <div class="personal-training-col-text">
                                                <h6 class="border-bottom">Trening personalny</h6>
                                                <p>{{ $personalTraining->name }} {{ $personalTraining->surname }}</p>
                                                <p class="semi-bold">{{ \Carbon\Carbon::parse($personalTraining->date_time_from)->format('H:i') }} - {{ \Carbon\Carbon::parse($personalTraining->date_time_to)->format('H:i') }}</p>
                                                    {!! Form::open(['action' => ['PersonalTrainingController@deleteUserPersonalTraining', $personalTraining->id_personal_training, $id_client], 'method' => 'POST']) !!}
                                                    {{Form::submit('Wypisz się', ['class' => 'btn btn-danger'])}}
                                                    {!! Form::close() !!}
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
