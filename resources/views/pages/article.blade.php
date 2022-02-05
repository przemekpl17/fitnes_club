@extends('layouts.app')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js"></script><script src="jquery.colorbox-min.js"></script>
    <script>
        $(document).ready(function () {
            $(".group3").colorbox({
                rel: 'group3',
                transition: "elastic", // fade,none,elastic
                width: "auto",
                height: "80%",
                current: "{current} / {total}",
                previous: "<",
                next: ">",
                close: "X",
                onComplete: function(){
                    var bg = $.colorbox.element().data('bg');
                    $('#cboxLoadedContent').css('backgroundColor', bg);
                }
            });
        });
    </script>

        <div class="single-article-container">
            <a href="/" class="btn btn-primary">Powrót</a>
            <div class="single-article-content">
                <div class="article-imag">
                    @if(count($article_images))
                        @foreach($article_images as $art_img)
                            <div class="single-article-img">
                                <a class="group3 cboxElement" href="../articles-images/{{$art_img->name}}"><img src="../articles-images/{{$art_img->name}}"></a>
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
