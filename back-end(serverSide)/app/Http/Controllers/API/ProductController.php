<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
{
    $products = Product::with('category')->get();

    $transformedProducts = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category->name, // اسم الفئة
            'description' => $product->description,
            'image_url' => $product->image_url,          
            'category' => optional($product->category)->name ?? 'بدون فئة',
        ];
    });

    return response()->json($transformedProducts, 200);
}

    public function show($id)
    {
        $product = Product::with('category')->find($id);
    
        if (!$product) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }
    
        $transformedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'category' => $product->category->name,
            'description' => $product->description,
            'image_url' => $product->image_url,
        ];
    
        return response()->json($transformedProduct, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'message' => 'تم إضافة المنتج بنجاح',
            'product' => $product
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'تم تعديل المنتج بنجاح',
            'product' => $product
        ], 200);
    }

        public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }
        $product->delete();

        return response()->json(['message' => 'تم حذف المنتج بنجاح'], 200);
    }
}
