<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Language;
use App\Models\NormalProductDetails;
use App\Models\Product;
use App\Models\ProductOptionValues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Tests\NewRequest;

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

        // choose one language to be the default one, let's make EN is the default
        // store master product
        // store the product in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Role - master
        $product = new Product;

        $category_id = Category::first()->id;
        $product->category_id = $category_id;

        // check saving success
        if (!$product->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $product_en = $product->productTrans()->create([
            'type' => $request->type_en,
            'name' => $request->name_en,
            'description' => $request->description_en,
            'notes' => $request->notes_en,
            'lang_id' => $en_id
        ]);

        // check saving status
        if (!$product_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->type_ar && $request->name_ar && $request->description_ar && $request->notes_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $product_ar = $product->productTrans()->create([
                'type' => $request->type_ar,
                'name' => $request->name_ar,
                'description' => $request->description_ar,
                'notes' => $request->notes_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$product_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        if ($request->type_en = 'normal') {

            $this->createNewNormalProduct($request);

        } elseif ($request->type_en = 'withPrice') {

            $this->createNewProductOtionValues($request);

        }

        return [
            'status' => true,
            'data' => [
                'product' => $product,
                'productTrans' => $product->productTrans()->getResults()
            ],
            'msg' => 'Data inserted successfully done',
        ];

    }


    public function createNewNormalProduct(Request $request)
    {
        // validation products
        $validation_normalProducts = [
            'price_en' => 'required',
            'serial_en' => 'required',
            'modelNumber_en' => 'required',
            'barcode_en' => 'required',
            'discount_en' => 'required',
            'stock_en' => 'required',
            'discount_type_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_normalProducts);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master product
        // store the product in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Role - master
        $normalProduct = new NormalProductDetails;
        $product = new Product;

        $product_id = Product::first()->id;
        $normalProduct->product_id = $product_id;

        if (!$normalProduct->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }
        // store en version
        $normalProduct_en = $product->normalProductDetails()->create([
            'discount_type' => $request->discount_type_en,
            'price' => $request->price_en,
            'serial' => $request->serial_en,
            'modelNumber' => $request->modelNumber_en,
            'barcode' => $request->barcode_en,
            'discount' => $request->discount_en,
            'stock' => $request->stock_en,
            'lang_id' => $en_id
        ]);

        // check saving status
        if (!$normalProduct_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }


        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->price_ar && $request->serial_ar && $request->modelNumber_ar && $request->barcode_ar && $request->discount_ar && $request->stock_ar && $request->discount_type_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $normalProduct_ar = $product->normalProductDetails()->create([
                'discount_type' => $request->discount_type_ar,
                'price' => $request->price_ar,
                'serial' => $request->serial_ar,
                'modelNumber' => $request->modelNumber_ar,
                'barcode' => $request->barcode_ar,
                'discount' => $request->discount_ar,
                'stock' => $request->stock_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$normalProduct_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        return [
            'status' => true,
            'data' => [
                'normalProduct' => $normalProduct,
            ],
            'msg' => 'Data inserted successfully done',
        ];
    }


    public function createNewProductOtionValues(Request $request)
    {

        // validation products
        $validation_normalProducts = [
            'price_en' => 'required',
            'serial_en' => 'required',
            'modelNumber_en' => 'required',
            'barcode_en' => 'required',
            'discount_en' => 'required',
            'stock_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_normalProducts);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master product
        // store the product in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Role - master
        $productOptionValues = new ProductOptionValues;
        $product = new Product;

        $product_id = Product::first()->id;
        $productOptionValues->product_id = $product_id;

        if (!$productOptionValues->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }
        // store en version
        $productOptionValues_en = $product->productOptionValue()->create([
            'price' => $request->price_en,
            'serial' => $request->serial_en,
            'modelNumber' => $request->modelNumber_en,
            'barcode' => $request->barcode_en,
            'discount' => $request->discount_en,
            'stock' => $request->stock_en,
            'lang_id' => $en_id
        ]);

        // check saving status
        if (!$productOptionValues_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->price_ar && $request->serial_ar && $request->modelNumber_ar && $request->barcode_ar && $request->discount_ar && $request->stock_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $productOptionValues_ar = $product->productOptionValue()->create([
                'price' => $request->price_ar,
                'serial' => $request->serial_ar,
                'modelNumber' => $request->modelNumber_ar,
                'barcode' => $request->barcode_ar,
                'discount' => $request->discount_ar,
                'stock' => $request->stock_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$productOptionValues_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        return [
            'status' => true,
            'data' => [
                'productOptionValues' => $productOptionValues,
            ],
            'msg' => 'Data inserted successfully done',
        ];
    }


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
