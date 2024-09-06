<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products

        if ($products->isNotEmpty()) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No records available'], 200);
        }
    }

    public function store(Request $request)
    {
        // Validate and store the product
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(), // Corrected to ->errors() to return validation errors
            ], 422);
        }

        $validated = $validator->validated(); // Get validated data

        $product = Product::create($validated); // Create product with validated data

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201); // Status code 201 for resource creation
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(), // Corrected to ->errors() to return validation errors
            ], 422);
        }

        $validated = $validator->validated(); // Get validated data

        $product->update($validated); // Update product with validated data

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ], 200); // Status code 200 for successful update
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
