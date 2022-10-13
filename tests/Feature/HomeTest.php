<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Hello world!');
        $response->assertSeeText('The current value is 0');
    }

    public function testContactPageIsworkingCorrectly()
    {
        $response=$this->get('/contact');

        $response->assertSeeText('Contact page');
    }
}
