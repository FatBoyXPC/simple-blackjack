<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
        <form method="POST" action="{{ route('games.deal', $game) }}">
            @csrf
            <button type="submit">Deal</button>
        </form>
        <form method="POST" action="{{ route('games.hit', $game) }}">
            @csrf
            <button type="submit">Hit</button>
        </form>
        <form method="POST" action="{{ route('games.stand', $game) }}">
            @csrf
            <button type="submit">Stand</button>
        </form>
        @include('partials.new-game')
        @yield('content')
    </body>
</html>
