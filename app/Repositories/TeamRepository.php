<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\EloquentRepository;

class TeamRepository extends EloquentRepository
{
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }
}
