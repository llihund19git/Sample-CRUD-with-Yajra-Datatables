<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getProducts() {
        $results = Product::where('user_id', auth()->id());
        
        return datatables()->of($results)
            ->addColumn('action', function ($results) {
                return [];
            })
            // ->filterColumn('product_name', function($query, $keyword) {    // If you add alias to name like product_name,
            //     $sql = "LOWER(CAST(products.name as TEXT)) like LOWER(?)"; // it will affect the search function of 
            //     $query->whereRaw($sql, ["%{$keyword}%"]);                  // datatables, so you need to add like these
            // })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $jsonData['is_success'] = 0;
        $name = $request->get('name');
        $price = $request->get('price');

        $product = new Product();
        $product->user_id = auth()->id();
        $product->name = $name;
        $product->price = $price;
        $newProduct = $product->save();

        if($newProduct)
            $jsonData['is_success'] = 1;

        return response()->json($jsonData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jsonData['is_success'] = 0;

        $id = $request->input('id');
        $name = $request->input('name');
        $price = $request->input('price');

        $product = Product::find($id);
        if($product) {
            $product->user_id = auth()->id();
            $product->name = $name;
            $product->price = $price;
            $product->save();

            $jsonData['is_success'] = 1;
        }

        return response()->json($jsonData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        // $product->delete(); for soft delete, you can restore deleted data.
        $product->forceDelete(); // permanent delete.

        $jsonData['is_success'] = 1;

        return response()->json($jsonData);
    }
}
