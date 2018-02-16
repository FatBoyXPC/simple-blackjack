<?php

namespace Tests\Unit\Collections;

use Tests\TestCase;
use App\Collections\CardsCollection;

class CardsCollectionTest extends TestCase
{
    /** @test */
    public function itCanBeConvertedToString()
    {
        $cards = new CardsCollection(['AH', 'KH']);

        $this->assertEquals('AH,KH', $cards);
    }

    /** @test */
    public function itCanCreateFromStringOfCards()
    {
        $cards = CardsCollection::makeFromString('AH,KH');

        $this->assertEquals(new CardsCollection(['AH', 'KH']), $cards);
    }
}
