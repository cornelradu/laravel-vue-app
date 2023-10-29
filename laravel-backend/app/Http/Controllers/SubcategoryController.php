<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class SubcategoryController extends Controller
{
    public function index()
    {
        $categories = SubCategory::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        // Create a new product
        $sub_category = SubCategory::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id')
        ]);

        return response()->json(['message' => 'Category created successfully', 'product' => $sub_category], 201);
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