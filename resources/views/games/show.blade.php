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
</p>
@endsection
