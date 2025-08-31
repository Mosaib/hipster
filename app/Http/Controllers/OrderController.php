<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Events\OrderStatusUpdated;

class OrderController extends Controller
{
    //get orders
    public function index(Request $request){
        $query = Order::query();
        $query->orderBy($request->sort ?? 'id', $request->sort_dir ?? 'desc');
        $orders =  $query->paginate($request->limit ?? 20);
        return view('admin.orders.index', compact('orders'));
    }


    //update order status
    public function updateOrder(Request $request, $id)
    {
        $request->validate([
        'status' => 'required|in:pending,shipped,delivered',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        event(new OrderStatusUpdated($order->id, $order->status));


        return redirect()->route('admin.order.index')->with('success', 'Order status updated successfully.');
    }



    ///***CUSTOMER***///
    public function placeOrderByCustomer(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        Order::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'status'     => 'pending',
            'quantity'   => $request->quantity,
        ]);

        $product->decrement('stock', $request->quantity);

        return redirect()->route('customer.products.index')->with('success', 'Order placed successfully!');
    }

    //get my order
    public function getByCustomerOrders(Request $request)
    {
        $query = Order::where('user_id', auth()->id());
        $query->orderBy($request->sort ?? 'id', $request->sort_dir ?? 'desc');
        $orders =  $query->paginate($request->limit ?? 10);
        return view('customer.products.myOrder', compact('orders'));
    }
}
