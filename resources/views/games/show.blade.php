@extends('layout')
@section('title', 'Play Blackjack!')

@section('content')
<p>
Game Status: {{ $game->status }}
<br>
Player Wins: {{ $game->wins_player }}
<br>
Dealer Wins: {{ $game->wins_dealer }}
</p>
<p>
Player Hand: {{ $game->playerHand }}
<br>
Dealer Hand: {{ $game->dealerHand }}

@if(@session('hand_status'))
    <br>
    <br>
    Hand {{ @session('hand_status') }}
@endif
</p>
@endsection
