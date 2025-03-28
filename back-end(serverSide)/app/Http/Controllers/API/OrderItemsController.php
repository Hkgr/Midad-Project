<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;

class OrderItemsController extends Controller
{
    public function index()
    {
        // تحميل العلاقات المطلوبة معاً
        $orderItems = OrderItem::with(['order', 'product'])->get();

        $transformedOrderItems = $orderItems->map(function ($orderItem) {
            return [
                'id'          => $orderItem->id,
                'order'       => $orderItem->order ? $orderItem->order->id : null,
                'product'     => $orderItem->product ? $orderItem->product->name : null,
                'total_price' => $orderItem->total_price,
                'quantity'    => $orderItem->quantity,
            ];
        });

        return response()->json($transformedOrderItems, 200);
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->find($id);

        if (!$orderItem) {
            return response()->json(['message' => 'العنصر غير موجود'], 404);
        }

        $transformedOrderItem = [
            'id'          => $orderItem->id,
            'order'       => $orderItem->order ? $orderItem->order->id : null,
            'product'     => $orderItem->product ? $orderItem->product->name : null,
            'total_price' => $orderItem->total_price,
            'quantity'    => $orderItem->quantity,
        ];

        return response()->json($transformedOrderItem, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'    => 'required|exists:orders,id',
            'product_id'  => 'required|exists:products,id',
            'total_price' => 'required|numeric',
            'quantity'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderItem = OrderItem::create($request->all());

        return response()->json([
            'message'   => 'تم إضافة العنصر بنجاح',
            'orderItem' => $orderItem
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'العنصر غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id'    => 'required|exists:orders,id',
            'product_id'  => 'required|exists:products,id',
            'total_price' => 'required|numeric',
            'quantity'    => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $orderItem->update($request->all());

        return response()->json([
            'message'   => 'تم تعديل العنصر بنجاح',
            'orderItem' => $orderItem
        ], 200);
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'العنصر غير موجود'], 404);
        }
        $orderItem->delete();

        return response()->json(['message' => 'تم حذف العنصر بنجاح'], 200);
    }
}
