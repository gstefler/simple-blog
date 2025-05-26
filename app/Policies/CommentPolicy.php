<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Comment $comment): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Comment $comment): bool
    {
        return false;
    }


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
