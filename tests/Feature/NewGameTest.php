<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewGameTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function guestCanCreateNewGame()
    {
        $response = $this->post(route('games.store'));
        $game = Game::first();

        $response->assertRedirect("games/{$game->id}");
        $this->assertCount(52, $game->cards());
        $this->assertEmpty($game->cardsused());
    }
}
