@extends('layouts.app')

@section('content')
    <a href="/articlesList" class="btn btn-primary">Powrót</a>
    {!! Form::open(['action' => ['AdminController@updateArticle', $article[0]->id_article], 'method' => 'POST', 'files' => true]) !!}

    <div class="form-row">
        <div class="form-group col-md-6">
            {{Form::label('title', 'Tytuł artykułu')}}
            {{Form::text('title',$article[0]->title, ['class' => 'form-control', 'placeholder' => 'tytuł'])}}
        </div>

        <div class="form-group col-md-6">
            <img src="../articles-images/{{$article_images[0]->name}}">
            {{$image_path}}
            {{Form::label('title', 'Dodaj zdjęcia')}}
            {{Form::file('article_id[]',['multiple' => 'multiple'], ['class' => 'form-control'])}}
        </div>

        <div class="form-group col-md-6">
            {{Form::label('title', 'Treść')}}
            {{Form::textarea('description',$article[0]->description, ['class' => 'form-control', 'placeholder' => 'treść'])}}
        </div>
    </div>

    {{Form::submit('Utwórz', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
