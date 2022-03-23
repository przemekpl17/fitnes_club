@extends('layouts.app')

@section('content')
        <div class="group-activities-content">
             <div class="swiper mySwiper ">
                <div class="swiper-wrapper ">
                    @foreach ($daysOfMonth as $key => $dayOfMonth)
                        <div class="swiper-slide group-activities-content">
                            @foreach($dayOfMonth as $key => $day)
                                <div class="group-activities-col">
                                    <div class="group-activities-col-header">
                                        <p class="week-date">{{$day['full_date']}}</p>
                                        <p class="week-name">{{$day['name_of_day']}}</p>
                                    </div>
                                        @foreach($day['activities'] as $activity)
                                            <div class="group-activities-col-text">
                                                <h6>{{ $activity->name }}</h6>
                                                <p class="semi-bold">{{$activity->date_time_from->format('H:i')}} - {{$activity->date_time_to->format('H:i')}}</p>
                                                <p>Nr sali: {{$activity->room_number}}</p>
                                                <p>Liczba uczestników:<br> @if(!$activity->enrolled_participants) 0 @else{{$activity->enrolled_participants}}@endif/{{$activity->max_participants}}</p>
                                                {!! Form::open(['action' => 'Clients_GroupActivitiesController@create', 'method' => 'POST']) !!}
                                                <input type="hidden" class="form-control" name="id_activity" value="{{$activity->id_group_activities}}">
                                                <input type="hidden" class="form-control" name="id_client" value="{{$id_client}}">
                                                <input type="hidden" class="form-control" name="date_from" value="{{$activity->date_time_from}}">
                                                <input type="hidden" class="form-control" name="date_to" value="{{$activity->date_time_to}}">
                                                <input type="hidden" class="form-control" name="actual_day" value="{{$day['number_of_day']}}">
                                                <input type="hidden" class="form-control" name="max_participants" value="{{$activity->max_participants}}">
                                                <input type="hidden" class="form-control" name="enrolled_participants" value="{{$activity->enrolled_participants}}">
                                                {{Form::submit('Zapisz się', ['class' => 'btn btn-dark'])}}
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
