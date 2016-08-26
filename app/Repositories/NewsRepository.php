<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\EloquentRepository;

class NewsRepository extends EloquentRepository
{
    public function __construct(News $news)
    {
        parent::__construct($news);
    }
}
