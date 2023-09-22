<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Todo;
use Carbon\Carbon;
use Tests\TestCase;


class TodoTest extends TestCase
{

    /** @test */
    public function testCreateTodo()
    {
        $data = [
            'title' => "Go to Church",
            'description' => "This is time for church",
            'due_date' => Carbon::now()->addDays(3),

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
    public function testGetAllTodos()
    {
        Todo::factory(3)->create();
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
        $data = [
            'title' => "Go to Church",
            'description' => "This is time for church",
            'due_date' => Carbon::now()->addDays(3)->toDateString(),

        ];
        $response = $this->put(route('todo.update', Todo::first()->id), $data);
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Todo updated successfully.",
            "data" => [
                "todo" => [
                    "title" => $data['title'],
                    "description" =>  $data['description'],
                    "due_date" =>  $data['due_date'],
                ]
            ]
        ]);
    }

    /** @test */
    public function updateIsComplete()
    {
        Todo::factory()->create(   
            [
                'is_complete' => false
            ]
    );
        $data = [
            'is_complete' => true,
        ];
        $response = $this->put(route('todo.update.is_complete', Todo::first()->id), $data);
        $response->assertStatus(200);
        $response->assertJson([
            "message" => "Todo updated successfully.",
            "data" => [
                "todo" => [
                    "is_complete" => $data['is_complete']
                ]
            ]
        ]);
    }

    /** @test */
    public function clearAllCompleted(){
        $this->withExceptionHandling();

        Todo::factory(5)->create(   
            [
                'is_complete' => true
            ]
        );
        Todo::factory(1)->create(   
            [
                'is_complete' => false
            ]
        );

            $response = $this->delete(route('todo.clear.all_completed'));
            $response->assertStatus(200);
            $todo = Todo::where('deleted_at', null)->get();
            $this->assertEquals($todo->count(), 1);

    }

}
