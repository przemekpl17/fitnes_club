<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('lightbox2/dist/css/lightbox.css')}}">
        <title>CORPO & BONITO</title>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
        <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    </head>
        <body>
            <div class="body-wrap">
                @include('inc.navbar')
                    <div class="container">
                        @include('inc.messages')
                        @yield('content')
                        <div class="push"></div>
                    </div>
                @include('inc.footer')
            </div>

            <script src="../lightbox2/src/js/lightbox.js"></script>
        </body>

    <script>
        var numOfSlides = document.querySelectorAll(".group-activities-content").length;
        console.log("numOfSlides: " + numOfSlides);/* 3 */
        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            initialSlide: 1,

        });

        $(function() {
            $(".datepicker").each(function(){
                $(this).datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    minDate: new Date(),
                    language: 'pl'
                });
            });
        });

    </script>


</html>
