<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use Yajra\Datatables\Datatables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function getProducts() {
        $results = Product::where('user_id', Auth::id());
        
        return Datatables::of($results)
            ->addColumn('action', function ($results) {
                return [];
            })
            // ->filterColumn('product_name', function($query, $keyword) {    // If you add alias to name like product_name,
            //     $sql = "LOWER(CAST(products.name as TEXT)) like LOWER(?)"; // it will affect the search function of 
            //     $query->whereRaw($sql, ["%{$keyword}%"]);                  // datatables, so you need to add like these
            // })
            ->make(true);
    }

    public function addProduct(Request $request) {
        $jsonData['is_success'] = 0;
        $name = $request->input('name');
        $price = $request->input('price');

        $product = new Product();
        $product->user_id = Auth::id();
        $product->name = $name;
        $product->price = $price;
        $newProduct = $product->save();

        if($newProduct)
            $jsonData['is_success'] = 1;

        return response()->json($jsonData);
    }

    public function editProduct(Request $request) {
        $jsonData['is_success'] = 0;

        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');

        $product = Product::find($id);
        if($product) {
            $product->user_id = Auth::id();
            $product->name = $name;
            $product->price = $price;
            $product->save();

            $jsonData['is_success'] = 1;
        }

        return response()->json($jsonData);
    }

    public function deleteProduct(Request $request) {
        $jsonData['is_success'] = 0;
        $id = $request->input('id');

        $product = Product::find($id);
        if($product) {
            // $product->delete(); for soft delete, you can restore deleted data.
            $product->forceDelete(); // permanent delete.

            $jsonData['is_success'] = 1;
        }
        return response()->json($jsonData);
    }
}
