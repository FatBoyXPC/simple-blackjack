<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    public function cards()
    {
        return $this->processCards($this->cards);
    }

    private function processCards($cards)
    {
        return collect(explode(',', $cards))->filter();
    }

    public function cardsUsed()
    {
        return $this->processCards($this->cards_used);
    }
}
