<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    //get product
    public function index(Request $request){
        $query = Product::query();
        $query->orderBy($request->sort ?? 'id', $request->sort_dir ?? 'desc');
        $products =  $query->paginate($request->limit ?? 20);
        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        return view('admin.products.create');
    }
}
