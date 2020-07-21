<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Resources\PostResource;
use App\Post;

class PostController extends Controller
{
    public function getList()
    {
        $posts = Post::query()
            ->where('user_id', '=', request()->user()->id)
            ->get();

        return new PostResource($posts);
    }

    public function store(StorePost $request)
    {
        $post = new Post();
        $post->user_id = request()->user()->id;
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->save();

        return $post;
    }
}
