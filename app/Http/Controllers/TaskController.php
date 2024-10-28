<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();

        return response()->json([
            'message' => 'Success',
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'unique:workspaces'],
            'type' => ['required', 'string'],
            'p_list_id' => ['required', 'exists:p_lists']
        ]);

        $task = Task::create([
            'name' => $data['name'],
            'user_id' => $request->user()->id,
            'type' => $data['type'],
            'p_list_id' => $data['p_list_id']
        ]);

        return response()->json([
            'message' => 'Success',
            'task' => $task
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
