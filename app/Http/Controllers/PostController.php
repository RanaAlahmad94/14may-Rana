<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ForbiddenWord;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('trashed')) {
            $posts = Post::onlyTrashed()->get();
        } else {
            $posts =Post::all();
        }

    return view('posts.index',compact('posts'));
    }
    public function userPosts(Request $request)
    {
        if ($request->has('trashed')) {
            $posts = Post::onlyTrashed()
                ->where('user_id','=',Auth::id())->get();
        } else {
            $posts = Auth::user()->posts;
        }

        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'desc' => 'required',
            'content' => 'required',
        ]);
    
        $user = Auth::user();
    
        if ($user->blocked) {
            return redirect()->back()->withErrors(['You are blocked from creating new posts.']);
        }
    
        $post = new Post();
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->content = $this->replaceForbiddenWords($request->content);
        $post->user_id = Auth::id();
        $post->save();
    
        return redirect()->route('posts.index');
    }
    
    private function replaceForbiddenWords($content)
    {
        $forbiddenWords = ForbiddenWord::pluck('word')->toArray();
        $forbiddenWordCount = 0;
    
        foreach ($forbiddenWords as $word) {
            if (strlen($word) < 4) {
                $replacement = substr($word, 0, 1) . str_repeat('*', strlen($word) - 1);
                } else {
                $replacement = substr($word, 0, 1) . str_repeat('*', strlen($word) - 2) . substr($word, -1, 1);
            }
            $content = str_ireplace($word, $replacement, $content, $count);
    
            $forbiddenWordCount += $count;
        }
    
        if ($forbiddenWordCount > 5) {
            $user = Auth::user();
            $user->blocked = true;
            $user->save();
        }
    
        return $content;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // dd('hi');
        $post = Post::find($id);
        $input = $request->all();
        $post->update($input);
        $post->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $post=Post::find($id);
       if($post->comments())
        $post->comments()->delete();
       $post->delete();

        return redirect('/');
    }
    public function restore($id)
    {
        Post::withTrashed()->find($id)->restore();
       // dd( Post::withTrashed()->count());
        return redirect()->back();
    }

    /**
     * restore all post
     *
     * @return response()
     */
    public function restoreAll()
    {
        Post::onlyTrashed()->restore();
        return redirect()->route('/');
    }

    public function allComments() {
        $posts = Auth::user()->posts()->with('comments')->get();
        // dd($posts);
        return view('posts.index',compact('posts'));
    }
}
