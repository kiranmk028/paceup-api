<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Models\Workspace;
use Exception;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Workspace $workspace)
    {
        if ($request->user()->cannot('viewAny', $workspace)) {
            throw new Exception("You don't have the permission to view the spaces of this workspace.");
        };

        $userSpaces = Space::where(['user_id' => $request->user()->id, 'workspace_id' => $workspace->id])->get();
        $invitedSpaces = $request->user()->invitedSpaces()->where('workspace_id', 1)->get();
        $spaces = $userSpaces->merge($invitedSpaces);

        return response()->json([
            'message' => 'Success',
            'spaces' => $spaces
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Workspace $workspace)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:workspaces'],
                'description' => ['nullable', 'string']
            ]);

            $data = array_merge($data, [
                'workspace_id' => $workspace->id
            ]);

            if ($request->user()->can('update', $workspace)) {
                $space = $request->user()->spaces()->create($data);
            }

            return response()->json([
                'message' => 'Success',
                'space' => $space
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Workspace $workspace, Space $space)
    {
        try {
            if ($request->user()->cannot('viewAny', $workspace) && $request->user()->cannot('view', $space)) {
                throw new Exception("You don't have the permission to view the spaces of this workspace.");
            };

            return response()->json([
                'status' => 'success',
                'message' => $space
            ]);
        } catch (Exception $exception) {
            $exception->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workspace $workspace, Space $space)
    {
        try {
            $data = $request->validate([
                'name' => ['string', 'unique:workspaces'],
                'description' => ['nullable', 'string']
            ]);

            if ($request->user()->cannot('update', $workspace) && $request->user()->cannot('update', $space)) {
                throw new Exception('You cannout update this workspace.');
            }

            $space->update($data);

            return response()->json([
                'message' => 'Success',
                'workspace' => $space
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Workspace $workspace, Space $space)
    {
        try {
            if ($request->user()->cannot('delete', $workspace) && $request->user()->cannot('delete', $space)) {
                throw new Exception('You cannout update this workspace.');
            }

            $space->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Workspace {$space->id} deleted successfully."
            ]);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
