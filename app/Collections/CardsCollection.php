<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class CardsCollection extends Collection
{
    public function __toString()
    {
        return $this->implode(',');
    }

    public static function makeFromString($cardsString)
    {
        return static::make(explode(',', $cardsString));
    }
}
