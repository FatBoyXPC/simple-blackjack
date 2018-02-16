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
        $this->withoutExceptionHandling();
        $game = Game::create([
            'cards' => '5C,2H,KH,AH',
        ]);

        $response = $this->followRedirects($this->post(route('games.deal', $game)));

        $response->assertSee('Game Status: Active');
        $response->assertSee('Player Hand: AH,KH');
        $response->assertSee('Dealer Hand: 2H,5C');
    }
}
