@extends('layouts.app')

@section('content')
    <div class="add-user">
        <a href="/addUserForm" class="btn btn-primary">Dodaj użytkownika</a>
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
            @foreach($users as $user)
                <tr>
                    <td>{{$loop->index+1}}.</td>
                    <td>{{$user->name}} {{$user->surname}}</td>
                    <td>{{$user->gender}}</td>
                    <td>{{$user->email}}</td>
                    <td>@if(!empty($user->city && $user->street)){{$user->city}}, ul. {{$user->street}}@endif</td>
                    <td>
                        <a href="/updateUserForm/{{ $user->id_client }}" class="btn btn-primary">Edytuj</a>
                        <a href="/deleteUser/{{ $user->id_client }}" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
