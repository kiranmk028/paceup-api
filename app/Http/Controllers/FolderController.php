<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Workspace;
use Exception;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Workspace $workspace)
    {
        if ($request->user()->cannot('view', $workspace)) {
            throw new Exception("You don't have the permission to view these folder.");
        }

        $folders = $workspace->folders()->get();

        return response()->json([
            'message' => 'Success',
            'folders' => $folders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:folders'],
                'description' => ['nullable', 'string'],
            ]);

            $data = array_merge($data, [
                'workspace_id' => $workspace->id
            ]);

            if ($request->user()->cannot('update', $workspace)) {
                throw new Exception("You don't have the required permisions to create folder here.");
            }

            $folder = $request->user()->folders()->create($data);

            return response()->json([
                'message' => 'Success',
                'folder' => $folder
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Workspace $workspace, Folder $folder)
    {
        try {
            if ($request->user()->cannot('view', $workspace)) {
                throw new Exception("You don't have the permission to view this folder");
            }

            return response()->json([
                'status' => 'success',
                'message' => $folder
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace, Folder $folder)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:folders'],
                'description' => ['nullable', 'string'],
            ]);

            $data = array_merge($data, [
                'workspace_id' => $workspace->id
            ]);

            if ($request->user()->cannot('update', $workspace)) {
                throw new Exception("You don't have the required permisions to update this folder.");
            }

            $folder->update($data);

            return response()->json([
                'message' => 'Success',
                'folder' => $folder
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workspace $workspace, Folder $folder)
    {
        try {
            if ($request->user()->cannot('update', $workspace)) {
                throw new Exception("You don't have the permission to delete this folder.");
            }

            if (!($folder->spaces->isEmpty() && $folder->pLists->isEmpty())) {
                throw new Exception("Folder must be empty for deletion.");
            }

            $folder->delete();

            return response()->json([
                'status' => 'Success',
                'message' => "Folder {$folder->id} deleted successfully"
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
