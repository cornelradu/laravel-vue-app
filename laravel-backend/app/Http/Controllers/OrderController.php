<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends BaseController
{
    public function get(Request $request) {

        $user_id = auth()->user()->id;

        $order_items = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->select('user_id', '=', $user_id)
                ->select('order_items.*', 'orders.timestamp')
                ->get();

    

        return response()->json($order_items, 200);
    }

    public function order(Request $request) {
        $orders = $request->only('orders');

        $order = new Order();
        $order->timestamp = now();
        $order->user_id = auth()->user()->id;
        $order->save();

        foreach($orders as $order2){
            foreach ($order2 as $key => $value) {
                $order_item = new OrderItem();
                $order_item->order_id = $order->id; 
                $order_item->product_id = intval($key);
                $order_item->count = intval($value);
                $order_item->save();
            }
            
        }

        return response()->json("Success", 200);
    }
}
