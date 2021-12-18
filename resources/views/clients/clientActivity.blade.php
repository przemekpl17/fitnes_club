@extends('layouts.app')

@section('content')
    <div class="container">
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
                                            <h5>Zajęcia grupowe</h5>
                                            <h5>{{ $activity->name }}</h5>
                                            <h5>{{$activity->date_time_from}} - {{$activity->date_time_to}}</h5>
                                            <p>Numer sali: {{$activity->room_number}}</p>
                                            <p>Maksymalna liczba uczestników: {{$activity->max_participants}}</p>
                                                {!! Form::open(['action' => ['Clients_GroupActivitiesController@destroy', $activity->id_client_group_activities], 'method' => 'POST']) !!}
                                                <input type="hidden" class="form-control" name="id_activity" value="{{$activity->id_group_activities}}">
                                                <input type="hidden" class="form-control" name="id_client" value="{{$id_client}}">
                                                {{Form::submit('Wypisz się', ['class' => 'btn btn-danger'])}}
                                                {!! Form::close() !!}
                                        </div>
                                    @endforeach
                                    @foreach($day['personal_training'] as $personal_training)
                                        <div class="group-activities-col-text">
                                            <h5>Trening personalny</h5>
                                            <h5>{{ $personal_training->name }} {{ $personal_training->surname }}</h5>
                                            <h5>{{$personal_training->date_time_from->format('H:i')}} - {{$personal_training->date_time_to->format('H:i')}}</h5>

                                            {{--                                            {!! Form::open(['action' => ['Clients_GroupActivitiesController@create', $activity->id_group_activities], 'method' => 'POST']) !!}--}}
                                            {{--                                            <input type="hidden" class="form-control" name="id_activity" value="{{$activity->id_group_activities}}">--}}
                                            {{--                                            <input type="hidden" class="form-control" name="id_client" value="{{$id_client}}">--}}
                                            {{--                                            <input type="hidden" class="form-control" name="date_from" value="{{$activity->date_time_from}}">--}}
                                            {{--                                            <input type="hidden" class="form-control" name="date_to" value="{{$activity->date_time_to}}">--}}
                                            {{--                                            <input type="hidden" class="form-control" name="actual_day" value="{{$day['number_of_day']}}">--}}
                                            {{--                                            {{Form::submit('Zapisz się', ['class' => 'btn btn-primary'])}}--}}
                                            {{--                                            {!! Form::close() !!}--}}
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

@endsection
