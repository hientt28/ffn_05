<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\EloquentRepository;

class CountryRepository extends EloquentRepository
{
    public function __construct(Country $country)
    {
        parent::__construct($country);
    }
}
