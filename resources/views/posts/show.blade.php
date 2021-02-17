@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>
                        #{{ $post->post_id}} - {{ __($post->post_title) }}

                    </h1>
                </div>

                <div class="card-body">
                    <p>
                        {{ __($post->post_content) }}
                    </p>
                <a class="btn" href="javascript:history.back()">Back</a>
                <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
