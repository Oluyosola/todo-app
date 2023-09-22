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
        $validated = $request->validated();
        $todo = $this->todoService->store($validated);

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
        $todo = $this->todoService->show($todoId);
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
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $validated = $request->validated();
        $todo = $this->todoService->update($validated, $todo);

        return ResponseBuilder::asSuccess()
            ->withHttpCode(\Illuminate\Http\Response::HTTP_OK)
            ->withData(['todo' => $todo])
            ->withMessage('Todo updated successfully.')
            ->build();
    }

    /**
     * Update the specified resource status in storage.
     *
     * @param  UpdateTodoRequest $request
     * @param  Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateIsComplete(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'is_complete' => 'required|in:0,1'
        ]);

        $todo = $this->todoService->updateIsComplete($validated, $todo);

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
        $todo = $this->todoService->destroy($todo);

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
        $todo = $this->todoService->restore($todo);

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
        $todo = $this->todoService->forceDelete($todo);

        return ResponseBuilder::asSuccess()
            ->withMessage('Todo permanently deleted successfully.')
            ->build();
    }

    public function clearAllCompleted()
    {
        $todo = $this->todoService->clearAllCompleted();

        return ResponseBuilder::asSuccess()
            ->withMessage('Completed Todos cleared.')
            ->build();
    }

}
