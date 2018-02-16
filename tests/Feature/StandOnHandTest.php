<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StandOnHandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function standOnGivenHandLoses()
    {
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => 'C5',
            'cards_used' => 'HK,H6,C10,S4',
            'hand_player' => 'HK,H6',
            'hand_dealer' => 'C10,S4',
        ]);

        $response = $this->followRedirects($this->post(route('games.stand', $game)));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Hand: HK,H6');
        $response->assertSee('Dealer Hand: C10,S4,C5');
        //$response->assertSessionHas('hand_status', 'Lose');

        tap($game->fresh(), function ($game) {
            $this->assertEquals(0, $game->wins_player);
            $this->assertEquals(1, $game->wins_dealer);
            $this->assertEmpty($game->cards);
            $this->assertEquals('HK,H6,C10,S4,C5', $game->cards_used);
        });
    }

    /** @test */
    public function standOnGivenHandWins()
    {
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => 'C5',
            'hand_player' => 'HK,H10',
            'hand_dealer' => 'C8,S4',
        ]);

        $response = $this->followRedirects($this->post(route('games.stand', $game)));

        $response->assertSee('Player Hand: HK,H10');
        $response->assertSee('Dealer Hand: C8,S4,C5');
        //$response->assertSessionHas('hand_status', 'Lose');

        tap($game->fresh(), function ($game) {
            $this->assertEquals(1, $game->wins_player);
            $this->assertEquals(0, $game->wins_dealer);
            $this->assertEmpty($game->cards);
        });
    }

    /** @test */
    public function standOnGivenHandTies()
    {
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => 'C5',
            'hand_player' => 'H7,H10',
            'hand_dealer' => 'C8,S4',
        ]);

        $response = $this->followRedirects($this->post(route('games.stand', $game)));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Hand: H7,H10');
        $response->assertSee('Dealer Hand: C8,S4,C5');
        //$response->assertSessionHas('hand_status', 'Lose');

        tap($game->fresh(), function ($game) {
            $this->assertEquals(0, $game->wins_player);
            $this->assertEquals(0, $game->wins_dealer);
            $this->assertEmpty($game->cards);
        });
    }
}
