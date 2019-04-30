<?php

namespace App\Http\Controllers\UserApp;

use App\Http\Controllers\Controller;
use App\Items;
use Illuminate\Http\Request;

/**
 * @group Items
 */
class ItemController extends Controller
{

    /**
     * Restrict the controller api methods.
     */
    public function __construct()
    {
        $this->authorizeResource(Item::class);
    }

    /**
     * List items
     *
     * Get a list of items in the database.
     *
     * @authenticated
     * //@responseFile responses/items.index.json
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responder()->success($this->user->phones);
    }

    /**
     * Store item
     *
     * Add a new item to the items collection.
     *
     * @bodyParam name string required
     * The name of the item. Example: Samsung Galaxy s10
     *
     * @bodyParam price number required
     * The price of the item. Example: 100.00
     *
     * @authenticated
     * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": {
     *          "id": 10,
     *          "price": 100.00,
     *          "name": "Samsung Galaxy s10"
     *      }
     * }
     *
     * @param  \Illuminate\Http\VerificationCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Get item
     *
     * Get item by it's unique ID.
     *
     * @pathParam item integer required
     * The ID of the item to retrieve. Example: 10
     *
     * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": {
     *          "id": 10,
     *          "price": 100.00,
     *          "name": "Samsung Galaxy s10"
     *      }
     * }
     * @authenticated
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $items)
    {
        //
    }
}
