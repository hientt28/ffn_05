<?php

namespace App\Repositories;

use App\Models\LeagueSeason;
use App\Repositories\EloquentRepository;

class LeagueSeasonRepository extends EloquentRepository
{
    public function __construct(LeagueSeason $leagueSeason)
    {
        parent::__construct($leagueSeason);
    }
}
