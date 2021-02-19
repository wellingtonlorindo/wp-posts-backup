<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ApiPostsTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\User')->create([
            'api_token' => 'owIydznBTNnRsnnBxS8UuTf3kbRolFrOehUartCuVOD4V92qTflJCk6fE2Zn'
        ]);
    }

    public function testUserCanAddAPost()
    {
        $post = [
            'post_id' => 16,
            'post_title' => 'My first post',
            'post_content' => 'The content here'
        ];

        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('POST', '/api/posts', $post);

        $response->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);

        $anotherPost = [
            'post_id' => 16,
            'post_title' => 'My first post',
            'post_content' => 'The content here'
        ];

        $posts[] = $post;
        $posts[] = $anotherPost;
        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('POST', '/api/posts', $posts);

        $response->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function testUserCantAddAPost()
    {
        $post = [
            'post_id' => 111,
            'post_title' => 'My post',
            'post_content' => 'The content here'
        ];

        $response = $this->withHeaders([
            'token' => null,
        ])->json('POST', '/api/posts', $post);

        $response->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated.",
            ]);

        $response = $this->withHeaders([
            'token' => 'aaaaaaaaaaaaaaaaaaaaaaaa',
        ])->json('POST', '/api/posts', $post);

        $response->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated.",
            ]);
    }

    public function testUserCanReadThePosts()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('GET', '/api/posts');

        $response->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);

        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('GET', '/api/posts/'.$post->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function testUserCantReadThePosts()
    {
        $anotherUser = factory('App\User')->create();
        $post = factory('App\Post')->create(['user_id' => $anotherUser->id]);
        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('GET', '/api/posts');

        $response->assertStatus(200)
            ->assertDontSee($post->post_title)
            ->assertJson([
                'status' => "success",
            ]);

        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->json('GET', '/api/posts/'.$post->id);

        $response->assertStatus(403)
            ->assertDontSee($post->post_title);
    }

    public function testUserCanEditAPost()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $postUpdated = [
            'post_id' => 123,
            'post_title' => 'My new title',
            'post_content' => 'The new content here'
        ];

        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->patch('/api/posts/'.$post->id, $postUpdated);

        $response->assertStatus(200)
            ->assertSee($postUpdated['post_id'])
            ->assertSee($postUpdated['post_title'])
            ->assertSee($postUpdated['post_content'])
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function testUserCantEditAPost()
    {
        $anotherUser = factory('App\User')->create();
        $post = factory('App\Post')->create(['user_id' => $anotherUser->id]);
        $postUpdated = [
            'post_id' => 123,
            'post_title' => 'My new title',
            'post_content' => 'The new content here'
        ];

        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->patch('/api/posts/'.$post->id, $postUpdated);

        $response->assertStatus(403)
            ->assertDontSee($postUpdated['post_id'])
            ->assertDontSee($postUpdated['post_title'])
            ->assertDontSee($postUpdated['post_content']);

        $postUpdatedAgain = [
            'post_content' => 'The new new content here...'
        ];

        $response = $this->withHeaders([
            'token' => $anotherUser->api_token,
        ])->patch('/api/posts/'.$post->id, $postUpdatedAgain);

        $response->assertStatus(403)
            ->assertDontSee($postUpdatedAgain['post_content']);
    }

    public function testUserCanDeleteAPost()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->delete('/api/posts/'.$post->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => "success",
            ]);
    }

    public function testUserCantDeleteAPost()
    {
        $anotherUser = factory('App\User')->create();
        $post = factory('App\Post')->create(['user_id' => $anotherUser->id]);
        $response = $this->withHeaders([
            'token' => $this->user->api_token,
        ])->delete('/api/posts/'.$post->id);

        $response->assertStatus(403);
    }
}