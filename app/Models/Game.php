<?php

namespace App\Models;

use App\Collections\CardsCollection;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    protected $casts = [
        'wins_player' => 'integer',
        'wins_dealer' => 'integer',
        'ended_at' => 'datetime',
    ];

    public function getStatusAttribute()
    {
        return $this->ended_at ? 'Over' : 'Active';
    }

    public function getPlayerHandAttribute()
    {
        return CardsCollection::makeFromString($this->hand_player);
    }

    public function getDealerHandAttribute()
    {
        return CardsCollection::makeFromString($this->hand_dealer);
    }

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
