<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    //get orders
    public function index(Request $request){
        $query = Order::query();
        $query->orderBy($request->sort ?? 'id', $request->sort_dir ?? 'desc');
        $orders =  $query->paginate($request->limit ?? 20);
        return view('admin.orders.index', compact('orders'));
    }



    ///***CUSTOMER***///

}
