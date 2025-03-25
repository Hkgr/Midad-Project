<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'الصنف غير موجود'], 404);
        }
        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|min:1|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create($request->all());

        return response()->json([
            'message' => 'تم إضافة الصنف بنجاح',
            'category' => $category
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'الصنف غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|min:1|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($request->all());

        return response()->json([
            'message' => 'تم تعديل الصنف بنجاح',
            'category' => $category
        ], 200);
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'المنتج غير موجود'], 404);
        }
        $category->delete();

        return response()->json(['message' => 'تم حذف الصنف بنجاح'], 200);
    }


}
