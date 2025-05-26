<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class CommentController extends Controller
{
    /**
     * @throws Throwable
     */
    public function store(CommentRequest $request, Post $post)
    {
        DB::transaction(function () use ($request, $post) {
            $comment = new Comment($request->validated());
            $comment->post()->associate($post);
            if ($request->user()) {
                $comment->user()->associate($request->user());
            }
            $comment->save();
        });
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();
    }
}
