<?php

namespace App\Repositories;

use App\Models\Award;
use App\Repositories\EloquentRepository;

class AwardRepository extends EloquentRepository
{
    public function __construct(Award $award)
    {
        parent::__construct($award);
    }
}
