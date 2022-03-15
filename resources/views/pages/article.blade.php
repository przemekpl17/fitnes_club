@extends('layouts.app')

@section('content')
        <div class="single-article-container">
            <a href="/" class="btn btn-primary">Powrót</a>
            <div class="single-article-content">
                <div class="article-imag">
                    @if(count($article_images))
                        @foreach($article_images as $art_img)
                            <div class="single-article-img">
                                <a class="lightbox-img" data-lightbox="{{$art_img->name}}" href="../articles-images/{{$art_img->name}}"><img src="../articles-images/{{$art_img->name}}"></a>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="single-article-text">
                    <div class="single-article-title">
                        <h3>{{ $article[0]->title}}</h3>
                    </div>

                    <div class="single-article-desc">
                        <p>{!!$article[0]->description!!}</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
