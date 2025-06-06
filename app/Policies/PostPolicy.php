<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Post $post): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Post $post): Response
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Post $post): Response
    {
        if ($user->is_admin) return Response::allow();
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
