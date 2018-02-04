<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ProductsController
 * @package App\Http\Controllers\API
 */
class ProductsController extends Controller
{
    //
    /**
     * @param $id
     * @return array
     */
    public function getProduct($id)
    {
        //find product by id
        $product = Product::find($id);

        //check if no product
        if (!$product) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }

        $product_translated = $product->translate();

        $product->product_translated = $product_translated;

        // check success status
        return [
            'status' => true,
            'data' => [
                'product' => $product,
            ],
            'msg' => 'successfully done!'
        ];
    }

    /**
     * @return array
     */
    public function getAllProducts()
    {
        // find all products in DB
        $products = Product::all();

        // check if no products
        if (count($products) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no products exist in DB'
            ];
        }

        // append translated products to all countries
        foreach ($products as $product) {

            // get product details
            $product_translated = $product->translate();

            // add the translated product as a key => value to main product object
            // key is product_translated and the value id $product_details
            $product->product_translated = $product_translated;
        }

        //check success status
        return [
            'status' => true,
            'data' => [
                'products' => $products,
            ],
            'msg' => 'Display All Countries'
        ];

    }


    /**
     * @param Request $request
     */
    public function createNewProduct(Request $request)
    {
        // validation products
        $validation_products = [
            'type_en' => 'required',
            'name_en' => 'required',
            'description_en' => 'required',
            'notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_products);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

    }

    /**
     * @param $id
     * @param Request $request
     */
    public function updateProduct($id, Request $request)
    {
        // validation products
        $validation_products = [
            'type_en' => 'required',
            'name_en' => 'required',
            'description_en' => 'required',
            'notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_products);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

    }


    /**
     * @param $id
     * @return array
     */
    public function deleteProduct($id)
    {
        //search  for product
        $product = Product::find($id);

        //if no product
        if (!$product) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no Product with this id!'
            ];
        }

        //delete productTrans
        $product->productTrans()->delete();

        //delete product
        $product->delete();

        //check  success status
        return [
            'status' => True,
            'data' => null,
            'msg' => 'Data is deleted successfully!'
        ];
    }


}
