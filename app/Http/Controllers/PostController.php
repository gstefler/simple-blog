<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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

    public function index(Request $request)
    {
        $query = Post::with('user:id,name')->latest();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }
        $posts = $query->paginate(10)->withQueryString();

        return Inertia::render('Posts/Index', [
            'posts'   => $posts,
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(PostRequest $request)
    {
        $request->user()->posts()->create($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => $post->load([
                'user:id,name',
                'comments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'comments.user:id,name',
            ]),
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
            'post' => $post->only(['id', 'title', 'content']),
        ]);
    }

    public function update(PostRequest $request, Post $post)
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
}
