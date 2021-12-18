<div class="flex-center">
    @if (Route::has('login'))
        <div class="top-right auth">
            @auth
                <a href="{{ url('/client') }}">{{Auth::user()->name}}</a>
                <a href="{{ url('/logout') }}">Wyloguj się</a>

            @else
                <a href="{{ route('login') }}">Zaloguj się</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Rejestracja</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="logo">
            <a href="/"><img src="/img/logo1.png"></a>
        </div>

        <div class="links">
            <a href="/tickets">kup karnet</a>
            <a href="/groupActivities">zajęcia grupowe</a>
            <a href="/personalTraining">trening personalny</a>
            <a href="/contact">kontakt</a>
        </div>
    </div>
</div>
