<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        $posts = cache()->remember('posts', 3600,  function (){
            return  Post::with('category','author')->latest()->filter(
                request(['search', 'category', 'author'])
            )->paginate(18)->withQueryString();
        }) ;
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
