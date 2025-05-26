<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): Response
    {
        if ($user->is_admin)
            return Response::allow();
        return $user->id === $comment->user_id ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
