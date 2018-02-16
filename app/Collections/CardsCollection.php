<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class CardsCollection extends Collection
{
    const CARD_VALUES = [
        'A' => 11,
        'K' => 10,
        'Q' => 10,
        'J' => 10,
        '10' => 10,
        '9' => 9,
        '8' => 8,
        '7' => 7,
        '6' => 6,
        '5' => 5,
        '4' => 4,
        '3' => 3,
        '2' => 2,
    ];

    public function __toString()
    {
        return $this->implode(',');
    }

    public static function makeFromString($cardsString)
    {
        return static::make(explode(',', $cardsString));
    }

    public function value()
    {
        return $this->sum(function ($card) {
            return $this->getCardValue(substr($card, 1));
        });
    }

    private function getCardValue($card)
    {
        return self::CARD_VALUES[$card];
    }
}
