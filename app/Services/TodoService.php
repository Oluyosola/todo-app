<?php

namespace App\Services;

use App\Models\Todo;


class ToDoService
{
  /**
   * Fetches all todos.
   */
  public function index()
  {
    return Todo::query();
  }

  /**
   * Fetches a todo by id.
   *
   * @param int $id
   * @return Todo
   */
  public function show(int $id)
  {
    return Todo::findOrFail($id);
  }

  /**
   * Creates a new todo.
   *
   * @param array $data
   * @return Todo
   */
  public function store($request)
  {

    $todo = Todo::create([
      'title' => $request['title'],
      'description' => $request['description'] ?? null,
      'due_date' => $request['due_date'],
    ]);

    return $todo->refresh();
  }

  /**
   * Updates a todo.
   *
   * @param $request
   * @param Todo $todo
   * @return Todo $todo
   */
  public function update($request, Todo $todo)
  {

    $todo->title = $request['title'];
    $todo->description = $request['description'] ?? null;
    $todo->due_date = $request['due_date'];
    $todo->save();

    return $todo;
  }

  /**
   * Updates todo status.
   *
   * @param $request
   * @param Todo $todo
   * @return Todo $todo
   */
  public function updateIsComplete($request, Todo $todo)
  {

    $todo->is_complete = $request['is_complete'];
    $todo->save();

    return $todo;
  }

  /**
   * Deletes a todo.
   *
   * @param Todo $todo
   * @return bool
   */
  public function destroy(Todo $todo)
  {
    return $todo->delete();
  }

    /**
   * Restores a todo.
   *
   * @param Todo $todo
   * @return bool
   */
  public function restore(Todo $todo)
  {
    return $todo->restore();
  }

      /**
   * Permanently delete a todo.
   *
   * @param Todo $todo
   * @return bool
   */
  public function forceDelete(Todo $todo)
  {
    return $todo->forceDelete();
  }
}
