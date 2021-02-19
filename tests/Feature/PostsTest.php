<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostsTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
        $this->actingAs($this->user);
        $this->assertAuthenticated();
    }

    public function testUserCanReadThePosts()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $response = $this->get('/posts');
        $response->assertViewIs('posts.index');
        $response->assertSee($post->post_title);
        $response->assertSee($post->post_id);
        $response->assertSee('Add new');
        $response->assertSee('Show');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
    }

    public function testUserCanAddAPost()
    {
        $response = $this->get('/posts/create');
        $response->assertViewIs('posts.create');
        $response->assertSee('ID');
        $response->assertSee('Title');
        $response->assertSee('Content');
        $response->assertSee('Save');

        $newPost = [
            'post_id' => 9999,
            'post_title' => 'My first post',
            'post_content' => 'My content here.',
        ];

        $response = $this->post('/posts', $newPost);
        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post stored successfully');
        $this->assertEquals(1, $this->user->posts()->count());
    }

    public function testUserCantAddAPost()
    {
        $post = factory('App\Post')->create([
            'user_id' => $this->user->id,
            'post_id' => 9999
        ]);
        $response = $this->get('/posts/create');

        $newPost = $post->toArray();
        $response = $this->post('/posts', $newPost);
        $response->assertStatus(302);

        $newPost['post_id'] = 9998;
        $newPost['post_title'] = null;
        $response = $this->post('/posts', $newPost);
        $response->assertStatus(302);

        $newPost['post_title'] = 'My title';
        $newPost['post_content'] = null;
        $response = $this->post('/posts', $newPost);
        $response->assertStatus(302);
    }

    public function testUserCanEditAPost()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $response = $this->get('/posts/'.$post->id.'/edit');

        $response->assertViewIs('posts.edit');
        $response->assertSee($post->id);
        $response->assertSee($post->post_title);
        $response->assertSee($post->post_id);
        $response->assertSee('Save');

        $newPost = $post->toArray();
        $newPost['post_title'] = 'Another Title';
        $response = $this->patch('/posts/'.$post->id, $newPost);
        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post updated successfully');
        $response = $this->get('/posts/'.$post->id.'/edit');
        $response->assertSee($newPost['post_title']);
    }

    public function testUserCantEditAPost()
    {
        $anotherUser = factory('App\User')->create();
        $post = factory('App\Post')->create(['user_id' => $anotherUser->id]);
        $response = $this->get('/posts/'.$post->id.'/edit');
        $response->assertStatus(403);
    }

    public function testUserCanDeleteAPost()
    {
        $post = factory('App\Post')->create(['user_id' => $this->user->id]);
        $response = $this->delete('/posts/'.$post->id);
        $response->assertRedirect('/posts');
        $response->assertSessionHas('success', 'Post deleted successfully');
        $response->assertDontSee($post->id);
    }

    public function testUserCantDeleteAPost()
    {
        $anotherUser = factory('App\User')->create();
        $post = factory('App\Post')->create(['user_id' => $anotherUser->id]);
        $response = $this->delete('/posts/'.$post->id);
        $response->assertStatus(403);
    }
}