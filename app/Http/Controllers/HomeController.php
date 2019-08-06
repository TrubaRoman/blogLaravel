<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(3);


        return view('pages.index')->with('posts',$posts);
    }

    public function show($slug)
    {
        $post = Post::where('slug',$slug)->firstOrFail();
        return view('pages.show',['post' => $post]);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug',$slug)->firstOrFail();
        $posts = $tag->posts()->where('status',1)->paginate(4);
        return view('pages.list',['posts' => $posts]);

    }

    public function category($slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        $posts = $category->posts()->where('status',1)->paginate(4);
        return view('pages.list',['posts'=> $posts]);
    }


}
