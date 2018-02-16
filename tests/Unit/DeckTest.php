<?php

namespace Tests\Unit;

use App\Deck;
use Tests\TestCase;
use App\Collections\CardsCollection;

class DeckTest extends TestCase
{
    /** @test */
    public function deckCanBeConvertedToString()
    {
        $deck = new Deck('AH,KH', '');

        $this->assertEquals('AH,KH', $deck);
    }

    /** @test */
    public function dealCanGiveCardToNewHand()
    {
        $deck = new Deck('AH,KH', '');

        $this->assertEquals(['KH'], $deck->deal(1)->toArray());
    }

    /** @test */
    public function dealCanGiveCardToSpecifiedHand()
    {
        $deck = new Deck('AH,KH', '');
        $hand = new CardsCollection(['10H']);

        $this->assertEquals(['10H','KH'], $deck->deal(1, $hand)->toArray());
    }

    /** @test */
    public function deckWillHaveUsedCards()
    {
        $deck = new Deck('AH,KH', '');
        $deck->deal(1);

        $this->assertEquals('KH', (string) $deck->used());
    }

    /** @test */
    public function deckWillShrinkAsCardsAreDealt()
    {
        $deck = new Deck('AH,KH', '');
        $deck->deal(1);

        $this->assertCount(1, $deck);
    }
}
