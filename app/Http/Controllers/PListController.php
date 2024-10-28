<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Space;
use App\Models\Folder;
use App\Models\Workspace;
use Illuminate\Http\Request;

class PListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Workspace $workspace)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'unique:p_lists'],
                'description' => ['nullable', 'string'],
                'start_date' => ['required', 'date_format:Y-m-d H:i:s'],
                'end_date' => ['required', 'date_format:Y-m-d H:i:s'],
                'space_id' => ['nullable', 'prohibits:folder_id', 'exists:spaces,id'],
                'folder_id' => ['nullable', 'prohibits:space_id', 'exists:folders,id'],
            ]);

            $data = array_merge($data, [
                'user_id' => $request->user()->id
            ]);

            $owner = $workspace;

            if (!empty($data['space_id']) && $data['space_id'] !== '') {
                $owner = Space::find($data['space_id']);

                if ($request->user()->cannot('create', $owner)) {
                    throw new Exception("No permission to create lists here.");
                }
            }

            if (!empty($data['folder_id']) && $data['folder_id'] !== '') {
                $owner = Folder::find($data['folder_id']);

                if ($request->user()->cannot('create', $owner)) {
                    throw new Exception("No permission to create lists here.");
                }
            }

            $pList = $owner->pLists()->create($data);

            return response()->json([
                'status' => 'success',
                'message' => $pList
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
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
