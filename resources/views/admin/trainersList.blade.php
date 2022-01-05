@extends('layouts.app')

@section('content')
    <div class="add-user">
        <a href="/admin" class="btn btn-primary">Powrót</a>
        <a href="/addTrainerForm" class="btn btn-primary">Dodaj trenera</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Lp.</td>
                <td>Imię i nazwisko</td>
                <td>Płeć</td>
                <td>Email</td>
                <td>Adres</td>
                <td>Opcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($trainers as $trainer)
                <tr>
                    <td>{{$loop->index+1}}.</td>
                    <td>{{$trainer->name}} {{$trainer->surname}}</td>
                    <td>{{$trainer->gender}}</td>
                    <td>{{$trainer->email}}</td>
                    <td>@if(!empty($trainer->city && $trainer->street)){{$trainer->city}}, ul. {{$trainer->street}}@endif</td>
                    <td>
                        <a href="/updateTrainerForm/{{ $trainer->id_trainer }}" class="btn btn-primary">Edytuj</a>
                        <a href="/deleteTrainer/{{ $trainer->id_trainer }}" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
