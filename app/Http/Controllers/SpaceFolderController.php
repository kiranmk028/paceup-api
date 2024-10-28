<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Space;
use App\Models\Folder;
use App\Models\Workspace;
use Illuminate\Http\Request;

class SpaceFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Workspace $workspace, Space $space)
    {
        if ($request->user()->cannot('view', $space)) {
            throw new Exception("No permission for you.");
        }

        $folders = $space->folders()->get();

        return response()->json([
            'status' => 'success',
            'message' => $folders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace, Space $space)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'unique:folders'],
                'description' => ['nullable', 'string'],
            ]);

            if ($request->user()->cannot('create', $space)) {
                throw new Exception("No permission for you to store folders here.");
            }

            $data = array_merge($data, [
                'user_id' => $request->user()->id,
                'space_id' => $space->id
            ]);

            $folder = Folder::create($data);

            return response()->json([
                'status' => 'success',
                'message' => $folder
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Workspace $workspace, Space $space, Folder $folder)
    {
        try {
            if ($request->user()->cannot('view', $space)) {
                throw new Exception("No permission for you.");
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
    public function update(Request $request, Workspace $workspace, Space $space, Folder $folder)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'unique:folders'],
                'description' => ['nullable', 'string'],
            ]);

            if ($request->user()->cannot('update', $space)) {
                throw new Exception("No permission for you to store folders here.");
            }

            $data = array_merge($data, [
                'user_id' => $request->user()->id,
                'space_id' => $space->id
            ]);

            $folder->update($data);

            return response()->json([
                'status' => 'success',
                'message' => $folder
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workspace $workspace, Space $space, Folder $folder)
    {
        try {
            if ($request->user()->cannot('delete', $space)) {
                throw new Exception('No permission for you to delete this folder');
            }
    
            $folder->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => "Folder {$folder->id} deleted successfully."
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
