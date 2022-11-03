<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        return [
            'title'=>$this->faker->sentence(10),
            'content'=>$this->faker->paragraphs(5,true),
        ];
    }

    // $factory->state(App\BlogPost::class, 'new-title', function (Faker $faker) {
    //     return [
    //         'title' => 'New title',
    //     ];
    // });

    public function new_title()
    {
        return $this->state(function(array $attributes){
            return[
                //removing one of the attribute will cause it to use the attribute in the definition method()

                'title'=>'New title',
                'content'=>'Content of the blog post',
            ];
        });
    }
}
