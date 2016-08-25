<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
