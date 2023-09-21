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
    $todo = new Todo();
    $todo->title = $request->title;
    $todo->description = $request->description;
    $todo->save();

    return $todo;
  }

  /**
   * Updates a todo.
   *
   * @param $request
   * @param Todo $todo
   * @return Todo $todo
   */
  public function updateIsActive(Todo $todo)
  {
    $todo->is_active = true;
    $todo->save();

    return $todo;
  }

  /**
   * Updates a todo.
   *
   * @param $request
   * @param Todo $todo
   * @return Todo $todo
   */
  public function updateIsComplete(Todo $todo)
  {
    $todo->is_complete = true;
    $todo->save();

    return $todo;
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
    $todo->title = $request->title;
    $todo->description = $request->description;
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
}
