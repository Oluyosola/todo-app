<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Todo;
use Faker\Generator;
use Tests\TestCase;


class TodoTest extends TestCase
{
    public Generator $faker;
    /** @test */

    public function testCreateTodo()
    {
        $data = [
            'title' => $this->faker->text,
            'description' => $this->faker->text,
            'due_date' => $this->faker->date,

        ];
        $response = $this->post(route('todo.create'), $data);
        $response->assertStatus(201);
        $response->assertJson([

            "message" => "Todo created successfully.",
            "data" => [
                "todo" => [
                    "title" => $data['title'],
                    "description" =>  $data['description'],
                    'due_date' => $data['due_date'],

                ]
            ]
        ]);
    }

    /** @test */

    public function testGettingAllTodos()
    {
        Todo::factory(3)->create();
        $this->withoutExceptionHandling();

        $response = $this->get(route('todo.show'));
        $response->assertStatus(200);

        $response->assertJsonStructure([

            "data" => [
                "todos"

            ]
        ]);
    }
    /** @test */

    public function testUpdateTodo()
    {
        Todo::factory(3)->create();
        $this->withoutExceptionHandling();
        $data = [
            'title' => "Go to Church",
            'description' => "This is time for church",
        ];
        $response = $this->put(route('todo.update', Todo::first()->id), $data);
        $response->assertStatus(200);
        $response->assertJson([

            "message" => "Todo updated successfully.",
            "data" => [
                "todo" => [
                    "title" => $data['title'],
                    "description" =>  $data['description'],
                ]
            ]
        ]);
    }
}
