<html>
<head>
    <title>All Posts</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="m-3 text-center">All Posts</h1>
    <table class="table table-bordered mb-3">
        <thead>
        <tr>
            <div class="card">
                                <div class="card-body">
                                    <a href="{{ url('/posts/create') }}" class="btn btn-success btn-sm" title="Add New post">
                                        Add New
                                    </a>
                                </div>
            </div>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->desc }}</td>
                <td>{{ $post->content }}</td>

                <td>
                <td>
                                                                <a href="{{ url('/posts/' . $post->id) }}" title="View post"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                                <a href="{{ url('/posts/' . $post->id . '/edit') }}" title="Edit post"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>


                @if(request()->has('trashed'))
                        <a href="{{ route('posts.restore', $post->id) }}" class="btn btn-success">Restore</a>
                    @else
                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-danger delete" title='Delete'>Delete</button>
                        </form>
                    @endif
                </td>
                @foreach($post->comments as $comment)
                <tr>
                <td>{{ $comment->content }}</td>
                </tr>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="float-end">
        @if(request()->has('trashed'))
            <a href="{{ route('posts.index') }}" class="btn btn-info">View All posts</a>
            <a href="{{ route('posts.restoreAll') }}" class="btn btn-success">Restore All</a>
        @else
        <a href="{{ route('posts.userPost', ['trashed' => 'post']) }}" class="btn btn-success">View Deleted posts</a>
        @endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.delete').click(function(e) {
            if(!confirm('Are you sure you want to delete this post?')) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
{{--@endsection--}}
