@extends('layouts.app')

@section('content')
    <div class="add-user">
        <a href="/admin" class="btn btn-primary">Powrót</a>
        <a href="/addArticleForm" class="btn btn-primary">Dodaj Artykuł</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <td>Lp.</td>
                <td>Tytuł artykułu</td>
                <td>Opis</td>
                <td>Opcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $key => $article)
                <tr>
                    <td>{{$loop->index+1}}.</td>
                    <td>{{$article->title}}</td>
                    <td>{{$short_desc[$key]}}..</td>
                    <td>
                        <a href="/updateArticleForm/{{ $article->id_article }}" class="btn btn-primary">Edytuj</a>
                        <a href="/deleteArticle/{{ $article->id_article }}" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
