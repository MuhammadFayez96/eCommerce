<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\NormalProductDetails;
use App\Models\Option;
use App\Models\OptionValues;
use App\Models\OptionValuesTranslation;
use App\Models\Product;
use App\Models\ProductOptionValues;
use App\Models\ProductOptionValuesDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ProductsControllerApi;

/**
 * Class ProductsController
 * @package App\Http\Controllers\Admin
 */
class ProductsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        // call afunction getIndex from ProductsControllerApi
        $getIndex_products = $products_api->getIndex();

        // if status true return this view
        return view('admin.pages.products.index', $getIndex_products['data']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewProduct()
    {
        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        // call a function getCreateNewProduct from Api
        $getNewProduct_api = $products_api->getCreateNewProduct();

        // check if stauts in false
        if($getNewProduct_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getNewProduct_api['msg']
            ];
        }

        // check if status is true return this view
        return view('admin.pages.products.add-product', $getNewProduct_api['data']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewProduct(Request $request)
    {
        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        // call afunction createNewProduct from api
        $newProduct_api = $products_api->createNewProduct($request);

        // check if status false
        if($newProduct_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $newProduct_api['msg']
            ];
        }

        //check if status true
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $newProduct_api['msg'],
        ];
    }


    /**
     * @param $id
     *  @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateProduct($id)
    {
        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        // call afunction getUpdateProduct from Api
        $getUpdateProduct_api = $products_api->getUpdateProduct($id);

        // check if status is false
        if($getUpdateProduct_api['status'] == false)
        {
            return [
                'staus' => 'error',
                'title' => 'Error',
                'text' => $getUpdateProduct_api['msg']
            ];
        }

        // check if status is true retirn this view
        return view('admin.pages.products.edit-product', $getUpdateProduct_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateProduct($id, Request $request)
    {
        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        // call afunction updateProduct from Api
        $updateProduct_api = $products_api->updateProduct($id,$request);

        // check if status is false
        if($updateProduct_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateProduct_api['msg']
            ];
        }

        // check save success
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $updateProduct_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteProduct($id)
    {

        // get object from ProductsControllerApi
        $products_api = new ProductsControllerApi();

        //call afunction deleteProduct from Api
        $deleteProduct_api = $products_api->deleteProduct($id);

        // check if status is false
        if($deleteProduct_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteProduct_api['msg']
            ];
        }

        //check  if status  is true
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $deleteProduct_api['msg']
        ];
    }
}
