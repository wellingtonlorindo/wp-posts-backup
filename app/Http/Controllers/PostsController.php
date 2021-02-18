<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function getPostIdRules(User $user)
    {
        return [
            Rule::unique('posts')->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            }),
            'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiIndex()
    {
        $posts = Auth::user()->posts()->get();
        return ['status' => 'success', 'posts' => $posts];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts()->get();
        return view('posts.index', compact('posts'));
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
     * Store a post or a list of posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiStore(Request $request)
    {
        $postsData = $request->json()->all();
        if (empty($postsData[0])) {
            $postsData = [$postsData];
        }

        $user = Auth::user();
        $arrayPosts = [];
        foreach ($postsData as $postData) {
            $request->json()->replace($postData);
            $data = $request->validate([
                'post_title' => 'required',
                'post_content' => 'required',
                'post_id' => 'required'
            ]);

            $arrayPosts[] = $user->posts()->updateOrCreate(
                ['user_id' => $user->id, 'post_id' => $postData['post_id']],
                $data
            );
        }

        return ['status' => 'success', 'message' => 'Post saved', 'posts' => $arrayPosts];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $returnData
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, bool $returnData = false)
    {
        $user = Auth::user();
        $data = request()->validate([
            'post_title' => 'required',
            'post_content' => 'required',
            'post_id' => $this->getPostIdRules($user)
        ]);

        $data['post_content'] = $request->post_content;

        $post = $user->posts()->create($data);

        if ($returnData) {
            return $post;
        }

        return redirect("/posts")
            ->with("success","Post stored successfully");;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function apiShow(Post $post)
    {
        $this->authorize('view', $post);
        return ['status' => 'success', 'post' => $post];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function apiUpdate(Request $request, Post $post)
    {
        $post = $this->update($request, $post, true);
        return ['status' => 'success', 'message' => 'Post updated', 'post' => $post];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @param  bool  $returnData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post,  bool $returnData = false)
    {
        $this->authorize('update', $post);
        $rules = [
            'post_title' => 'required',
            'post_content' => 'required',
        ];

        if ($request->post_id != $post->post_id) {
            $user = Auth::user();
            $rules['post_id'] = $this->getPostIdRules($user);
        }

        $data = request()->validate($rules);
        $data['post_content'] = $request->post_content;

        $post->update($data);
        if ($returnData) {
            return $post;
        }

        return redirect("/posts")
            ->with("success","Post updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function apiDestroy(Post $post)
    {
        $post = $this->destroy($post, true);
        return ['status' => 'success', 'message' => 'Post deleted'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @param  bool  $returnData
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, bool $returnData = false)
    {
        $this->authorize('delete', $post);
        $response = $post->delete();
        if ($returnData) {
            return $response;
        }

        return redirect("/posts")
            ->with("success","Post deleted successfully");
    }
}
