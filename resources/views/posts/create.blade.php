@extends('posts.layout')
@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">Create New posts</div>
        <div class="card-body">

            <form action="{{ url('posts') }}" method="post">
                {!! csrf_field() !!}
                <label>Title</label></br>
                <input type="text" name="title" id="name" class="form-control"></br>
                <label>Description</label></br>
                <input type="text" name="desc" id="address" class="form-control"></br>
                <label>Content</label></br>
                <input type="text" name="content" id="mobile" class="form-control"></br>
                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>
