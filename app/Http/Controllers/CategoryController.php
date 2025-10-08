<?php

namespace App\Http\Controllers;

use App\Models\DocNumber;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function generateCategoryCode()
    {
        try {
            $doc = DocNumber::where('type', 'Category')->first();

            if (!$doc) {
                // If no category document exists, create one
                $doc = DocNumber::create([
                    'type' => 'Category',
                    'prefix' => 'CAT',
                    'last_id' => 0
                ]);
            }

            $nextId = $doc->last_id + 1;
            $number = $doc->prefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'message' => 'Code generated successfully',
                'code' => $number
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate code',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'success' => true,
                'message' => 'Categories fetched successfully',
                'data' => CategoryResource::collection($categories)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($cat_code)
    {
        try {
            $category = Category::where('cat_code', $cat_code)->firstOrFail();
            return response()->json([
                'success' => true,
                'message' => 'Category fetched successfully',
                'data' => new CategoryResource($category)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();

            // Check if Category code already exists
            if (Category::where('cat_code', $data['cat_code'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category code already exists'
                ], 422);
            }

            // Handle image upload
            if ($request->hasFile('cat_image')) {
                $imagePath = $request->file('cat_image')->store('categories', 'public');
                $data['cat_image'] = $imagePath;
            }

            $data['created_by'] = auth()->id();
            $category = Category::create($data);

            $doc = DocNumber::where('type', 'Category')->first();
            if ($doc) {
                $doc->last_id += 1;
                $doc->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CategoryRequest $request, $cat_code)
    {
        try {
            $category = Category::where('cat_code', $cat_code)->firstOrFail();
            $data = $request->validated();

            // Handle image update if provided
            if ($request->hasFile('cat_image')) {
                // Delete old image if exists
                if ($category->cat_image) {
                    Storage::disk('public')->delete($category->cat_image);
                }

                $imagePath = $request->file('cat_image')->store('categories', 'public');
                $data['cat_image'] = $imagePath;
            }

            $data['updated_by'] = auth()->id();
            $category->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($category)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}