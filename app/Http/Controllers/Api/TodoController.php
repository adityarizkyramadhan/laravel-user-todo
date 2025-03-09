<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show all data with pagination
        $data = Todo::paginateFindAndFilter(
            filter: request()->all(),
            sort: request()->all(),
            perPage: request()->query('per_page', 10)
        );

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|in:pending,completed',
            ]);

            // Simpan data
            $todo = Todo::create($validatedData);

            // Kembalikan respons sukses
            return response()->json([
                'message' => 'Todo created successfully',
                'data' => $todo,
            ], 201);
        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return response()->json([
                'message' => 'Failed to create Todo',
                'error' => $e->getMessage(),
            ], 500);
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
