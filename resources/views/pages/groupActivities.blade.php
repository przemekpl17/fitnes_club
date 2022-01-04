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
                                                <h5>{{ $activity->name }}</h5>
                                                <h5>{{$activity->date_time_from->format('H:i')}} - {{$activity->date_time_to->format('H:i')}}</h5>
                                                <p>Numer sali: {{$activity->room_number}}</p>
                                                <p>Maksymalna liczba uczestników: {{$activity->max_participants}}</p>
                                                {!! Form::open(['action' => 'Clients_GroupActivitiesController@create', 'method' => 'POST']) !!}
                                                <input type="hidden" class="form-control" name="id_activity" value="{{$activity->id_group_activities}}">
                                                <input type="hidden" class="form-control" name="id_client" value="{{$id_client}}">
                                                <input type="hidden" class="form-control" name="date_from" value="{{$activity->date_time_from}}">
                                                <input type="hidden" class="form-control" name="date_to" value="{{$activity->date_time_to}}">
                                                <input type="hidden" class="form-control" name="actual_day" value="{{$day['number_of_day']}}">
                                                {{Form::submit('Zapisz się', ['class' => 'btn btn-primary'])}}
                                                {!! Form::close() !!}
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
