<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::paginate($request->get('per_page', 16));
        return response()->json($categories);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::create($validated);
        return response()->json([
            'message' => 'Category created successfully',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,],], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $category = Category::findOrFail($id);
    return response()->json($category);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCategory(Request $request, $id)
{
    $category = Category::findOrFail($id);
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $category->update($validated);
    
    return response()->json([
        'message' => 'Category updated successfully',
        'category' => [
            'id' => $category->id,
            'name' => $category->name,
        ],
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
