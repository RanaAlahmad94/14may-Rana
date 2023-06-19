<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function getPosts(Request $request)
    {

        if ($request->has('trashed')) {
            $posts = Post::onlyTrashed()
                ->get();
        } else {
            $posts = Post::all();
        }

        return view('posts.index',compact('posts'));
    }


}
