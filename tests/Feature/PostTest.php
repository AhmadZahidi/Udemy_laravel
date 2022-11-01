<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found!');
    }

    // public function testSee1BlogPostWhenThereIs1() 
    // {
    //     // Arrange
    //     $post = $this->createDummyBlogPost();

    //     // Act
    //     $response = $this->get('/posts');

    //     // Assert
    //     $response->assertSeeText('New title');
    //     $response->assertSeeText('Content of the blog post');

    //     $this->assertDatabaseHas('blog_posts', [
    //         'title' => $post->title
    //     ]);
    // }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 3 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts',[
            'title'=>$post->title,
            'content'=>$post->content,
            'updated_at'=>$post->updated_at,
            'created_at'=>$post->created_at,
            'id'=>$post->id
        ]);

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title'
        ]);
    }

    public function testDelete() 
    {
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts', [
            'title'=>$post->title,
            'content'=>$post->content,
            'updated_at'=>$post->updated_at,
            'created_at'=>$post->created_at,
            'id'=>$post->id
        ]);

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was delete!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost(): BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        return $post;
    }
}
