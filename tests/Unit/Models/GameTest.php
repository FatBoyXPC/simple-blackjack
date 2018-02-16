<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    /** @test */
    public function cardsReturnsCollectionOfCards()
    {
        $game = Game::make([
            'cards' => 'AH,AS,AD,AC',
        ]);

        $cards = collect(['AH', 'AS', 'AD', 'AC']);

        $this->assertEquals($cards, $game->cards());
    }

    /** @test */
    public function cardsUsedReturnsCollectionOfCardsUsed()
    {
        $game = Game::make([
            'cards_used' => 'KH,KS,KD,KC',
        ]);

        $cards = collect(['KH', 'KS', 'KD', 'KC']);

        $this->assertEquals($cards, $game->cardsUsed());
    }

    /** @test */
    public function statusIsActiveWithoutEndedAtTimestamp()
    {
        $game = Game::make([
            'ended_at' => null,
        ]);

        $this->assertEquals('Active', $game->status);
    }

    /** @test */
    public function statusIsOverWithEndedAtTimestamp()
    {
        $game = Game::make([
            'ended_at' => (string) now(),
        ]);

        $this->assertEquals('Over', $game->status);
    }

    /** @test */
    public function playerHandShowsCardsAndValue()
    {
        $game = Game::make([
            'hand_player' => 'HA,HK',
        ]);

        $this->assertEquals('HA,HK (21)', $game->playerHand);
    }
}
