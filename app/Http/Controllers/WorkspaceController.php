<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $workspaces = Workspace::where('user_id', $request->user()->id)->get();

        return response()->json([
            'message' => 'Success',
            'workspaces' => $workspaces
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:workspaces'],
                'description' => ['nullable', 'string']
            ]);

            $workspace = $request->user()->workspaces()->create($data);

            return response()->json([
                'message' => 'Success',
                'workspace' => $workspace
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace)
    {
        return response()->json([
            'status' => 'success',
            'message' => $workspace
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:workspaces'],
                'description' => ['nullable', 'string']
            ]);

            if ($request->user()->cannot('update', $workspace)) {
                throw new Exception('You cannout update this workspace.');
            }

            $workspace->update($data);

            return response()->json([
                'message' => 'Success',
                'workspace' => $workspace
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workspace $workspace)
    {
        try {
            if ($request->user()->cannot('delete', $workspace)) {
                throw new Exception('You cannout update this workspace.');
            }

            $workspace->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Workspace {$workspace->id} deleted successfully."
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
