<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitOnHandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hitOnGivenHand()
    {
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => 'C5',
            'hand_player' => 'HK,H6',
            'hand_dealer' => 'C10,S4',
        ]);

        $response = $this->followRedirects($this->post(route('games.hit', $game)));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Hand: HK,H6,C5');
        $response->assertSee('Dealer Hand: C10,S4');

        $this->assertEmpty($game->fresh()->cards);
    }

    /** @test */
    public function hitOnGivenHandBusts()
    {
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => 'C6',
            'hand_player' => 'HK,H6',
            'hand_dealer' => 'C10,S4',
        ]);

        $response = $this->followRedirects($this->post(route('games.hit', $game)));

        $response->assertSee('Player Hand: HK,H6,C6');
        $response->assertSee('Dealer Hand: C10,S4');
        $response->assertSee('Lost');

        $this->assertEquals(1, $game->fresh()->wins_dealer);
    }
}
