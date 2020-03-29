<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reviews\ReviewsRequest;
use App\Http\Resources\ReviewResource;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $products)
    {

        return ReviewResource::collection($products->reviews);
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
    public function store(ReviewsRequest $request, Product $products)
    {
        //


        $review = new Review($request->all());

        $products->reviews()->save( $review);

        return response()->json([
            'msn' => 'Creo Reviews',
            'data' => new ReviewResource($review)
        ],  Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $products, Review $review)
    {
        //



        $review->update($request->all());
        return response()->json([
            'msn' => 'Actualizo Reviews',
            'data' => new ReviewResource($review)
        ],  Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $products ,Review $review)
    {
        //
        $review->delete();
        return response()->json([
            'msn' => 'Delete review'
        ], Response::HTTP_RESET_CONTENT);
    }
}
