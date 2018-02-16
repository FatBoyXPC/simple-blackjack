<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Collections\CardsCollection;

class GameController extends Controller
{
    const MAX_DEALER_VALUE = 16;
    const MAX_HAND_VALUE = 21;

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
        $deck = new Deck($game->cards, $game->cards_used);
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

    public function hit(Game $game)
    {
        $deck = new Deck($game->cards, $game->cards_used);
        $playerHand = $deck->deal(1, CardsCollection::makeFromString($game->hand_player));

        $game->fill([
            'hand_player' => $playerHand,
            'cards' => $deck,
            'cards_used' => $deck->used(),
        ]);

        if ($playerHand->value() > self::MAX_HAND_VALUE) {
            $data = $this->loseHand($game);
        }

        $game->save();

        return redirect()->route('games.show', $game)->with($data ?? []);
    }

    private function loseHand($game)
    {
        $game->wins_dealer++;

        $data = [
            'hand_status' => 'Lost',
        ];

        if ($game->shouldEnd()) {
            $game->ended_at = now();
        }

        return $data;
    }

    public function stand(Game $game)
    {
        $deck = new Deck($game->cards, $game->cards_used);
        $dealerHand = $this->dealerHitsUntilMaximumValue(CardsCollection::makeFromString($game->hand_dealer), $deck);

        $game->fill([
            'hand_dealer' => $dealerHand,
            'cards' => $deck,
            'cards_used' => $deck->used(),
        ]);

        $this->updateWinner($game)->save();

        return redirect()->route('games.show', $game)->with([
            'hand_status' => $game->playerHandStatus,
        ]);
    }

    private function dealerHitsUntilMaximumValue(CardsCollection $dealerHand, Deck $deck)
    {
        if ($dealerHand->value() >= self::MAX_DEALER_VALUE) {
            return $dealerHand;
        }

        $deck->deal(1, $dealerHand);

        return $this->dealerHitsUntilMaximumValue($dealerHand, $deck);
    }

    private function updateWinner(Game $game)
    {
        $player = CardsCollection::makeFromString($game->hand_player);
        $dealer = CardsCollection::makeFromString($game->hand_dealer);

        if ($player->value() > self::MAX_HAND_VALUE) {
            $game->wins_dealer++;

            return $game;
        }

        if ($dealer->value() > self::MAX_HAND_VALUE) {
            $game->wins_player++;

            return $game;
        }

        if ($player->value() == $dealer->value()) {
            return $game;
        }

        if ($dealer->value() > $player->value()) {
            $game->wins_dealer++;

            return $game;
        }

        $game->wins_player++;

        if ($game->shouldEnd()) {
            $game->ended_at = now();
        }

        return $game;
    }
}
