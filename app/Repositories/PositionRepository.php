<?php

namespace App\Repositories;

use App\Models\Position;
use App\Repositories\EloquentRepository;

class PositionRepository extends EloquentRepository
{
    public function __construct(Position $position)
    {
        parent::__construct($position);
    }
}
