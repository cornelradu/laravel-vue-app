<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Create a new product
        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Category created successfully', 'product' => $category], 201);
    }

    public function show($id)
    {
        // Return a specific product by ID
    }

    public function update(Request $request, $id)
    {
        // Validate and update product by ID
    }

    public function destroy($id)
    {
        // Delete product by ID
    }
}
