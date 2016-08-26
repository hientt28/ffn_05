<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\EloquentRepository;

class NotificationRepository extends EloquentRepository
{
    public function __construct(Notification $notification)
    {
        parent::__construct($notification);
    }
}
