@extends('layouts.app')

@section('content')

    <a href="/articlesList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => 'AdminController@createArticle', 'method' => 'POST', 'files' => true]) !!}

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Tytuł artykułu')}}
            {{Form::text('title','', ['class' => 'form-control', 'placeholder' => 'tytuł'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Dodaj zdjęcia')}}
            {{Form::file('article_id[]',['multiple' => 'multiple'], ['class' => 'form-control'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Treść')}}
            {{Form::textarea('description','', ['class' => 'form-control', 'placeholder' => 'treść'])}}
        </div>
    </div>

    {{Form::submit('Utwórz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
