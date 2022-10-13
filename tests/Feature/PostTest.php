<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found!');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange
        $post=new BlogPost();
        $post->title="New Title";
        $post->content="Content of the blog post";
        $post->save();

        //Act
        $response=$this->get('/posts');

        //Assert
        $response->assertSeeText('New Title');
        
        $this->assertDatabaseHas('blog_posts',[
            'title'=>'New Title'
        ]);
    }

    public function testStoreValid()
    {

        $params = [
            'title' => 'abc',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog was created!');
    }

    public function testStoreFail()
    {
        $this->withoutMiddleware();
        $params=[
            'title'=>'x',
            'content'=>'x'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

            $messages=session('errors')->getMessages();
            $this->assertEquals($messages['title'][0],'The title must be at least 3 characters.');
            $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        // $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->assertDatabaseHas('blog_posts',[
            'id'=>$post->id,
            'created_at'=>$post->created_at,
            'updated_at'=>$post->updated_at,
            'title'=>$post->title,
            'content'=>$post->content
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

}
