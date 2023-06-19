@extends('posts.layout')
@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">Edit post</div>
        <div class="card-body">

            <form action="{{ url('posts/' .$post->id) }}" method="post">
                {!! csrf_field() !!}
                @method("PATCH")
                <input type="hidden" name="id" id="id" value="{{$post->id}}" id="id" />
                <label>title</label></br>
                <input type="text" name="title" id="name" value="{{$post->title}}" class="form-control"></br>
                <label>description</label></br>
                <input type="text" name="desc" id="address" value="{{$post->desc}}" class="form-control"></br>
                <label>content</label></br>
                <input type="text" name="content" id="mobile" value="{{$post->content}}" class="form-control"></br>
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>

        </div>
    </div>

@stop
