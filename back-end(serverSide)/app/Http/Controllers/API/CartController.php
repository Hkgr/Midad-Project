<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;



class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('user')->get();

        $transformedCarts = $carts->map(function ($cart) {
            return [
                'id' => $cart->id,
                'user' => $cart->user->name,
                'total_price' => $cart->total_price,
                'quantity' => $cart->quantity,
                'user' => optional($cart->user)->name ?? 'بدون اسم مستخدم',
            ];
        });

        return response()->json($transformedCarts, 200);
    }
    public function show($id)
    {
        $cart = Cart::with('user')->find($id);

        if (!$cart) {
            return response()->json(['message' => 'السلة غير موجود'], 404);
        }

        $transformedCarts = [
            'id' => $cart->id,
            'user' => $cart->user->name,
            'total_price' => $cart->total_price,
            'quantity' => $cart->quantity,
        ];

        return response()->json($transformedCarts, 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'total_price'       => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart = Cart::create($request->all());

        return response()->json([
            'message' => 'تم إضافة السلة بنجاح',
            'cart' => $cart
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'السلة غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'user_id' => 'required|exists:user,id',
            'total_price'       => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart->update($request->all());

        return response()->json([
            'message' => 'تم تعديل السلة بنجاح',
            'cart' => $cart
        ], 200);
    }
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json(['message' => 'السلة غير موجود'], 404);
        }
        $cart->delete();

        return response()->json(['message' => 'تم حذف السلة بنجاح'], 200);
    }
}
