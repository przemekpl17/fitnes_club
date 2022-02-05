@extends('layouts.app')

@section('content')

    @if(count($articles) > 0)
        <div class="articles-container">

            @foreach($articles as $key => $article)

                <div class="article-content">
                    <div class="article-img">
                        @if(count($article) > 0)<img src="../articles-images/{{$article[0]->name}}">@endif
                    </div>

                    <div class="article-text">
                        <div class="article-title">
                            <h3>@if(count($article) > 0){{$article[0]->title}}@endif</h3>
                        </div>

                        <div class="article-short-desc">
                            <p>{!! $short_desc[$key] !!}...</p>
                            <div class="article-bottom-content">
                                <p class="article-add-date">data dodania: <strong>{{$article_date[$key]}}</strong></p>
                                <a href="/article/@if(count($article) > 0){{$article[0]->id_article}}@endif" class="btn btn-primary">Czytaj więcej</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
