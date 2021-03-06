<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Requests\product\ProductRequest;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return  ProductCollection::collection(Product::all());
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
    public function store(ProductRequest $request)
    {



        try {
            $product = new Product();
            $product->name = $request->name;
            $product->detail = $request->description;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->save();


            return response()->json([
                'msn' => 'Creo Producto',
                'data' => new ProductResource($product)
            ], Response::HTTP_CREATED);
        } catch (\Exception $th) {
            return response()->json([
                'data' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //

            $this->ProductUserCheck($product);

            $request['detail'] = $request->description;
            unset($request['description']);

            $product->update($request->all());
            return response()->json([
                'msn' => 'Actualizo Producto',
                'data' => new ProductResource($product)
            ],  Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //

        try {


            $product->delete();
            return response()->json([
                'msn' =>"Product Delete"
            ],  Response::HTTP_NO_CONTENT);
        } catch (\Exception $th) {
            return response()->json([
                'data' => $th
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function ProductUserCheck($product){

        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser();
        }

    }
}
