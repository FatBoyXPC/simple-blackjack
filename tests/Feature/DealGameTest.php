<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealGameTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function dealCardForGame()
    {
        $game = Game::create([
            'cards' => 'C5,H2,HK,HA',
        ]);

        $response = $this->followRedirects($this->post(route('games.deal', $game)));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Hand: HA,HK');
        $response->assertSee('Dealer Hand: H2,C5');
    }
}
