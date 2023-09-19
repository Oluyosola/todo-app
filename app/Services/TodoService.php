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
 
}