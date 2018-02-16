<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewGameTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function viewNewGame()
    {
        $game = Game::create([]);

        $response = $this->get(route('games.show', $game));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Wins: 0');
        $response->assertSee('Dealer Wins: 0');
    }

    /** @test */
    public function viewGameThatHasBeenPlayed()
    {
        $game = Game::create([
            'wins_player' => 5,
            'wins_dealer' => 8,
        ]);

        $response = $this->get(route('games.show', $game));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Wins: 5');
        $response->assertSee('Dealer Wins: 8');
    }

    /** @test */
    public function viewEndedGame()
    {
        $game = Game::create([
            'wins_player' => 5,
            'wins_dealer' => 8,
            'ended_at' => now(),
        ]);

        $response = $this->get(route('games.show', $game));

        $response->assertSee('Game Status: Over');
        $response->assertSee('Player Wins: 5');
        $response->assertSee('Dealer Wins: 8');
    }
}
