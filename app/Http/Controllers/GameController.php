<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function store(Request $request)
    {
        $game = Game::create([
            'cards' => $this->createDeck()->implode(','),
        ]);

        return redirect()->route('games.show', $game);
    }

    private function createDeck()
    {
        $suits = collect(['H', 'S', 'D', 'C']);
        $values = collect(['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K']);

        return $suits->crossJoin($values)->map(function ($card) {
            return implode('', $card);
        });
    }

    public function show(Game $game, Request $request)
    {
        return view('games.show', [
            'game' => $game,
        ]);
    }

    public function deal(Game $game)
    {
        $deck = new Deck($game->cards);
        $playerHand = $deck->deal(2);
        $dealerHand = $deck->deal(2);

        $game->update([
            'hand_player' => $playerHand,
            'hand_dealer' => $dealerHand,
            'cards' => $deck,
            'cards_used' => $deck->used(),
        ]);

        return redirect()->route('games.show', $game);
    }
}
