<?php

namespace App\Repositories;

use App\Models\UserMatch;
use App\Repositories\EloquentRepository;

class UserMatchRepository extends EloquentRepository
{
    public function __construct(UserMatch $userMatch)
    {
        parent::__construct($userMatch);
    }
}
