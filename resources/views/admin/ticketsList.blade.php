@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        @if(!$tickets->isEmpty())
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Lp.</td>
                        <td>Typ karnetu</td>
                        <td>Opis</td>
                        <td>Cena</td>
                        <td>Data zakupu</td>
                        <td>Data zakończenia</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{$loop->index+1}}.</td>
                            <td>{{$ticket->type}}</td>
                            <td>{{$ticket->description}}</td>
                            <td>{{$ticket->price}}</td>
                            <td>{{$ticket->date_from}}</td>
                            <td>{{$ticket->date_to}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert-success">Brak karnetów w tym miesiącu.</div>
        @endif
    </div>
@endsection
