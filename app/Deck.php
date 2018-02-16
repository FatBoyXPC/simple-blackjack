<?php

namespace App;

use Countable;
use Illuminate\Support\Collection;
use App\Collections\CardsCollection;

class Deck implements Countable
{
    protected $cards;

    protected $used;

    public function __construct($deck)
    {
        $this->cards = CardsCollection::makeFromString($deck);
        $this->used = new CardsCollection;
    }

    public function __toString()
    {
        return (string) $this->cards;
    }

    public function deal($amount, CardsCollection $hand = null)
    {
        if (!$hand) {
            $hand = new CardsCollection;
        }

        Collection::times($amount, function () use ($hand) {
            $card = $this->cards->pop();
            $hand->push($card);
            $this->used->push($card);
        });

        return $hand;
    }

    public function used()
    {
        return $this->used;
    }

    public function count()
    {
        return $this->cards->count();
    }
}
