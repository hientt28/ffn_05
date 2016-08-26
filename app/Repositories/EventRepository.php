<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\EloquentRepository;

class EventRepository extends EloquentRepository
{
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }
}
