<?php

namespace App\Repositories;

use App\Models\LeagueSeasonTeam;
use App\Repositories\EloquentRepository;

class LeagueSeasonTeamRepository extends EloquentRepository
{
    public function __construct(LeagueSeasonTeam $leagueSeasonTeam)
    {
        parent::__construct($leagueSeasonTeam);
    }
}
