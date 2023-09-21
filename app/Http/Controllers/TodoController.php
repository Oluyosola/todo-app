<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\QueryBuilder\QueryBuilder;


class TodoController extends Controller
{

    private TodoService $todoService;

    /**
     * Inject the dependencies needed for the controller.
     *
     * @return void
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $todos = QueryBuilder::for($this->todoService->index())
            ->allowedFilters([
                'is_complete',
                'is_active'
            ])
            ->paginate($request->per_page);

        return ResponseBuilder::asSuccess()
            ->withMessage('Todos fetched successfully.')
            ->withData(['todos' => $todos])
            ->build();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTodoRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreTodoRequest $request)
    {
        $todo = $this->todoService->store($request);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(\Illuminate\Http\Response::HTTP_CREATED)
            ->withData(['todo' => $todo])
            ->withMessage('Todo created successfully.')
            ->build();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $todoId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($todoId)
    {
        $todo = QueryBuilder::for($this->todoService->index()->where('id', $todoId))
            ->allowedIncludes([
                'artisan',
                'category',
            ])
            ->firstOrFail();
        return ResponseBuilder::asSuccess()
            ->withData(['todo' => $todo])
            ->withMessage('Todo fetched successfully.')
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTodoRequest $request
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateIsActive(Todo $todo)
    {
        $todo = $this->todoService->updateIsActive($todo);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(\Illuminate\Http\Response::HTTP_OK)
            ->withData(['todo' => $todo])
            ->withMessage('Todo updated successfully.')
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTodoRequest $request
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateIsComplete(Todo $todo)
    {
        $todo = $this->todoService->updateIsComplete($todo);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(\Illuminate\Http\Response::HTTP_OK)
            ->withData(['todo' => $todo])
            ->withMessage('Todo updated successfully.')
            ->build();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTodoRequest $request
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo = $this->todoService->update($request, $todo);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(\Illuminate\Http\Response::HTTP_OK)
            ->withData(['todo' => $todo])
            ->withMessage('Todo updated successfully.')
            ->build();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return ResponseBuilder::asSuccess()
            ->withMessage('Todo deleted successfully.')
            ->build();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function restore(Todo $todo)
    {
        $todo->restore();

        return ResponseBuilder::asSuccess()
            ->withMessage('Todo restored successfully.')
            ->build();
    }

    /**
     * Permanently delete the specified resource from storage.
     *
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function forceDelete(Todo $todo)
    {
        $todo->forceDelete();

        return ResponseBuilder::asSuccess()
            ->withMessage('Todo permanently deleted successfully.')
            ->build();
    }
}
