<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 10), 1), 100);

        $products = Product::query()
            ->with(['category', 'warehouse'])
            ->latest()
            ->paginate($perPage);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:30'],
            'stock' => ['nullable', 'numeric'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product berhasil dibuat',
            'data' => $product->load(['category', 'warehouse']),
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => $product->load(['category', 'warehouse']),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product->id)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'warehouse_id' => ['nullable', 'exists:warehouses,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'cost_price' => ['sometimes', 'numeric', 'min:0'],
            'unit' => ['sometimes', 'string', 'max:30'],
            'stock' => ['sometimes', 'numeric'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $product->update($data);

        return response()->json([
            'message' => 'Product berhasil diupdate',
            'data' => $product->load(['category', 'warehouse']),
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product berhasil dihapus',
        ]);
    }
}
