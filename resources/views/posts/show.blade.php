@extends('posts.layout')
@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">posts Page</div>
        <div class="card-body">
            <div class="card-body">
                <h5 class="card-title">Title : {{ $post->title }}</h5>
                <p class="card-text">desc : {{ $post->desc }}</p>
                <p class="card-text">content : {{ $post->content }}</p>
            </div>

        </div>
        <a href="/posts">Go Back Home</a>
    </div>
