<?php

namespace App\Repositories;

use App\Models\Season;
use App\Repositories\EloquentRepository;

class SeasonRepository extends EloquentRepository
{
    public function __construct(Season $season)
    {
        parent::__construct($season);
    }
}
