<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;


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


    //store
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category'    => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // get by id
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }


    //edit by id
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    //update
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name'        => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category'    => 'nullable|string|max:255',
            'stock'       => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');

    }

    //download in csv
    public function downloadCsv()
    {
        $products = Product::all();

        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        $columns = ['ID', 'Name', 'Description', 'Price', 'Category', 'Stock', 'Image', 'Created At', 'Updated At'];
        $callback = function() use ($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->category,
                    $product->stock,
                    $product->image,
                    $product->created_at,
                    $product->updated_at,
                ]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }


    //import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,txt|max:204800',
        ]);

        try {
            $import = new ProductsImport;

            Excel::import($import, $request->file('file'));

            if (!empty($import->failuresMessages)) {
                return redirect()->back()->with('error', $import->failuresMessages);
            }

            return redirect()->back()->with('success', 'CSV/Excel imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => $e->getMessage()]);
        }
    }





    //**Customer */
    // get by customer
    public function getByCustomer(Request $request){
        $query = Product::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        $query->orderBy('id', $request->sort_dir ?? 'desc');
        $products =  $query->paginate($request->limit ?? 10);
        return view('customer.products.index', compact('products'));
    }
}
