<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::published()->ofType('berita')->latest('published_at')->latest('id')->paginate(9),
        ]);
    }

    public function show(Post $post)
    {
        abort_unless(Post::published()->whereKey($post->id)->exists(), 404);

        return view('posts.show', ['post' => $post]);
    }
}
