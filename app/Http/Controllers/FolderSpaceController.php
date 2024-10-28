<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Space;
use App\Models\Folder;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;

class FolderSpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Workspace $workspace, Folder $folder)
    {
        try {
            if ($request->user()->cannot('view', $workspace)) {
                throw new Exception("No permission to vew these spaces.");
            }

            $spaces = $folder->spaces()->get();

            return response()->json([
                'status' => 'success',
                'message' => $spaces
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace, Folder $folder)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'unique:spaces'],
                'description' => ['nullable', 'string']
            ]);

            $data = array_merge($data, [
                'user_id' => $request->user()->id,
                'workspace_id' => $workspace->id,
                'folder_id' => $folder->id
            ]);

            if ($request->user()->cannot('create', $workspace)) {
                throw new Exception("No permission for you to create space here.");
            }

            $space = Space::create($data);

            return response()->json([
                'status' => 'Success',
                'message' => $space
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Workspace $workspace, Folder $folder, Space $space)
    {
        try {
            if ($request->user()->cannot('view', $space)) {
                throw new Exception("No permission to vew these spaces.");
            }

            return response()->json([
                'status' => 'success',
                'message' => $space
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace, Folder $folder, Space $space)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'unique:spaces'],
                'description' => ['nullable', 'string']
            ]);

            $data = array_merge($data, [
                'user_id' => $request->user()->id,
                'workspace_id' => $workspace->id,
                'folder_id' => $folder->id
            ]);

            if ($request->user()->cannot('update', $space)) {
                throw new Exception("No permission for you to update this space.");
            }

            $space->update($data);

            return response()->json([
                'status' => 'Success',
                'message' => $space
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workspace $workspace, Folder $folder, Space $space)
    {
        try {
            if ($folder->spaces->isEmpty() && $folder->pLists->isEmpty()) {
                throw new Exception("Folder must be empty to be deleted.");
            }

            if ($request->user()->cannot('delete', $space)) {
                throw new Exception("You cannot delete this folder.");
            }

            $space->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Space {$space->id} deleted successfully."
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
