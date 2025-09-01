<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     //get product
    public function index(Request $request){
        // $query = User::whereNot('id', auth()->id());
        $query = User::query();
        $query->orderBy($request->sort ?? 'id', $request->sort_dir ?? 'desc');
        $users =  $query->paginate($request->limit ?? 20);
        return view('admin.users.index', compact('users'));
    }
}
