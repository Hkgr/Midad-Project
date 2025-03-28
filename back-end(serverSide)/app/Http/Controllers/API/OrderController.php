<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();
        
        $transformedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'user' => $order->user->name,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'user' => optional($order->user)->name ?? 'بدون اسم مستخدم',
            ];
        });

        return response()->json($transformedOrders, 200);
    }

    public function show($id)
    {
        $order = Order::with('user')->find($id);

        if (!$order) {
            return response()->json(['message' => 'الطلب غير موجود'], 404);
        }

        $transformedOrders = [
            'id' => $order->id,
            'user' => $order->user->name,
            'total_price' => $order->total_price,
            'status' => $order->status,
        ];

        return response()->json($transformedOrders, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::create($request->all());

        return response()->json([
            'message' => 'تم إضافة الطلب بنجاح',
            'order' => $order
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'الطلب غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order->update($request->all());

        return response()->json([
            'message' => 'تم تعديل السلة بنجاح',
            'order' => $order
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'الطلب غير موجود'], 404);
        }
        $order->delete();

        return response()->json(['message' => 'تم حذف لطلب بنجاح'], 200);
    }



}
