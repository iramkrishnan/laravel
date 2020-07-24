<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Resources\PostResource;
use App\Post;
use App\Rules\NoSpecialChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getList()
    {
        $posts = Post::query()
            ->where('user_id', '=', request()->user()->id)
            ->get();

        return new PostResource($posts);
    }

    public function store(Request $request) // Can use StorePost
    {
//        $request->validate([
//            'title' => 'bail|required|unique:posts|max:255',
//            'body.body' => ['required'],
//        ]);

        $rules = [
            'title' => ['bail', 'required', 'unique:posts', 'max:255', new NoSpecialChars],
            'body' => 'required',
            'sub_title' => 'exclude_unless:title,|required',
        ];

        $messages = [
            'title.required' => 'A :attribute is required',
            'body.required' => 'A :attribute is required',
            'sub_title.required' => 'A :attribute is required',
        ];

        $attributes = [
            'title' => 'Title',
            'body' => 'Body',
            'sub_title' => 'Sub Title'
        ];

        $validated = Validator::make($request->all(), $rules, $messages, $attributes);

        $validated->after(function ($validated) use ($request) {
            if (is_numeric($request['title'])) {
                $validated->errors()->add('title', 'Title cannot be an integer');
            }
        })->validate();

        $post = new Post();
        $post->user_id = request()->user()->id;
        $post->title = $validated->validated()['title'];
        $post->body = $validated->validated()['body'];
        $post->save();

        return $post;
    }
}
