@extends('layouts.app')

@section('content')

    @if(count($tickets) > 0)
        <div class="tickets-container">
            @foreach($tickets as $ticket)
                <div class="ticket-info">
                    <h4>Karnet {{ $ticket->ticket_type}}</h4>
                    <h2 class="semi-bold"> {{ $ticket->price }} zł</h2>
                    <p> {{ $ticket->description }} </p>
                    {!! Form::open(['action' => ['TicketsController@create', $ticket->id_ticket], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('Wybierz datę rozpoczęcia karnetu:') !!}
                            {!! Form::text('input_date',null, ['class' => 'form-control datepicker']) !!}
                        </div>
                    <input type="hidden" class="form-control" name="ticket_length" value="{{$ticket->ticket_length}}">
                    <input type="hidden" class="form-control" name="price" value="{{$ticket->price}}">
                    <input type="hidden" class="form-control" name="id_client" value="{{$client_info->id_client}}">
                    <input type="hidden" class="form-control" name="account_balance" value="{{$client_info->account_balance}}">
                    <input type="hidden" class="form-control" name="ticket_type" value="{{$ticket->ticket_type}}">
                    {{Form::submit('Kup Karnet', ['class' => 'btn btn-dark'])}}
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
    @endif


@endsection

