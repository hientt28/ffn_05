<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Repositories\BaseRepository;

class TeamRepository extends BaseRepository
{
    public function __construct(Team $team)
    {
        parent::__construct($team);
    }
}
