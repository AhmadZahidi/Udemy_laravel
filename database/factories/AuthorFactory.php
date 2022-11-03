<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;
use App\Models\Author;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function afterCreating(Author $author)
    {
        $author->profile()->save(Profile::factory()->make());
    }

    public function afterMaking(Author $author)
    {
        $author->profile()->save(Profile::factory()->make());
    }

    // public function configure()
    // {
    //     return $this->afterMaking(function (Author $author) {
    //         $author->profile()->save(Profile::factory()->make());
    //     })->afterCreating(function (Author $author) {
    //         $author->profile()->save(Profile::factory()->make());
    //     });
    // }

 
}
