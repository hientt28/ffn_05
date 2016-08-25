<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\EloquentRepository;

class CommentRepository extends EloquentRepository
{
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }
}
