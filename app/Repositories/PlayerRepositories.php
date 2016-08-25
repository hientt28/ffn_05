<?php

namespace App\Repositories;

use App\Models\Player;
use App\Repositories\EloquentRepository;

class PlayerRepository extends EloquentRepository
{
    public function __construct(Player $player)
    {
        parent::__construct($player);
    }
}
