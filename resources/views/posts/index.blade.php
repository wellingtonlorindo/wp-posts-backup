@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="col-sm-12">

                      @if(session()->get('success'))
                        <div class="alert alert-success">
                          {{ session()->get('success') }}  
                        </div>
                      @endif
                    </div>
                    <div class="card-header">Posts</div>
                    <a class="btn btn-info" href="{{ route('posts.create') }}">Add new</a>
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Post ID</th>
                                <th>Post title</th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>#{{$post->post_id}}</td>
                                    <td>{{$post->post_title}}</td>
                                    <td>
                                        <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                                            <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>
                                            <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                id="{{$post->post_id}}"
                                                type="submit"
                                                onclick="return confirmDeletePost(this);"
                                                class="btn btn-danger"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <a class="btn" href="javascript:history.back()">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
      function confirmDeletePost(that) {
          if(!confirm("Are you sure to delete post #" + that.id + " ?")) {
            event.preventDefault();
          }
      }
     </script>
@endsection
