<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user:id,name')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(StorePostRequest $request)
    {
        $request->user()->posts()->create($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => $post->load('user:id,name', 'comments.user:id,name'),
            'can' => [
                'update' => Gate::allows('update', $post),
                'delete' => Gate::allows('delete', $post),
            ],
        ]);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);
        $post->update($request->validated());

        return redirect()->route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function storeComment(Request $request, Post $post) // Consider creating a StoreCommentRequest
    {
        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $comment = new Comment($validated);
        $comment->post()->associate($post);
        if ($request->user()) {
            $comment->user()->associate($request->user());
        }
        $comment->save();

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }

    public function destroyComment(Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comment deleted successfully.');
    }
}
