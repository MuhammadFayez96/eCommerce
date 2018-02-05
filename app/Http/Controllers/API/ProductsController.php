<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Language;
use App\Models\NormalProductDetails;
use App\Models\OptionValues;
use App\Models\Product;
use App\Models\ProductOptionValues;
use App\Models\ProductOptionValuesDetails;
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
     * @return array
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

        }
        if ($request->type_en = 'withPrice') {

            $this->createNewProductOptionValues($request);

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


    /**
     * @param Request $request
     * @return array
     */
    public function createNewNormalProduct(Request $request)
    {
        // validation products
        $validation_normalProducts = [
            'price' => 'required',
            'serial' => 'required',
            'modelNumber' => 'required',
            'barcode' => 'required',
            'discount' => 'required',
            'stock' => 'required',
            'discount_type' => 'required',
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

        $normalProduct = new NormalProductDetails;

        $product_id = Product::first()->id;

        $normalProduct->product_id = $product_id;
        $normalProduct->price = $request->price;
        $normalProduct->serial = $request->serial;
        $normalProduct->model_number = $request->modelNumber;
        $normalProduct->barcode = $request->barcode;
        $normalProduct->discount = $request->discount;
        $normalProduct->stock = $request->stock;
        $normalProduct->discount_type = $request->discount_type;

        if (!$normalProduct->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }

        return [
            'status' => true,
            'data' => [
                'normalProduct' => $normalProduct,
            ],
            'msg' => 'Data inserted successfully done',
        ];
    }


    /**
     * @param Request $request
     * @return array
     */
    public function createNewProductOptionValues(Request $request)
    {
//        dd($request->all());
        // validation products
        $validation_productOptionValues = [
            'price' => 'required',
            'serial' => 'required',
            'modelNumber' => 'required',
            'barcode' => 'required',
            'discount' => 'required',
            'stock' => 'required',
        ];

        $validation = validator($request->all(), $validation_productOptionValues);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }


        $productOptionValues = new ProductOptionValues;

        $product_id = Product::first()->id;
        $productOptionValues->product_id = $product_id;
        $productOptionValues->price = $request->price;
        $productOptionValues->serial = $request->serial;
        $productOptionValues->model_number = $request->modelNumber;
        $productOptionValues->barcode = $request->barcode;
        $productOptionValues->discount = $request->discount;
        $productOptionValues->stock = $request->stock;

        if (!$productOptionValues->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }


        $productOptionValuesDetails = new ProductOptionValuesDetails;

        $productOptionValuesDetails->option_value_id = 1;
        $productOptionValuesDetails->product_option_value_id = 1;

        if ($productOptionValuesDetails->save()) {
            return [
                'status' => true,
                'data' => [
                    'productOptionValues' => $productOptionValues,
                ],
                'msg' => 'Data inserted successfully done',
            ];

        }

    }


    /**
     * @param $id
     * @param Request $request
     * @return array
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

        $product = Product::find($id);

        //check if no product
        if (!$product) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product with this id!'
            ];
        }

        //check save status
        if ($product->save()) {

            $product_en = $product->translate(1);
            $product_en->type = $request->type_en;
            $product_en->name = $request->name_en;
            $product_en->description = $request->description_en;
            $product_en->notes = $request->notes_en;

            // check save status
            if (!$product_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->type_en = 'normal') {
                $this->updateNormalProductDetails($id, $request);

            }
            if ($request->type_en = 'withPrice') {
                $this->updateProductOptionValues($id, $request);
            }

            if ($request->type_ar && $request->name_ar && $request->description_ar && $request->notes_ar) {
                $product_ar = $product->translate(2);
                $product_ar->type = $request->type_ar;
                $product_ar->name = $request->name_ar;
                $product_ar->description = $request->description_ar;
                $product_ar->notes = $request->notes_ar;

                // check save status
                if (!$product_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }


            // check save success
            return [
                'status' => true,
                'data' => [
                    'product' => $product
                ],
                'msg' => 'Data updated successfully done',
            ];
        }

    }


    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateNormalProductDetails($id, Request $request)
    {
        // validation products
        $validation_normalProducts = [
            'price' => 'required',
            'serial' => 'required',
            'modelNumber' => 'required',
            'barcode' => 'required',
            'discount' => 'required',
            'stock' => 'required',
            'discount_type' => 'required',
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
        $normal_product_details = NormalProductDetails::where('product_id', $id)->first();

        if (!$normal_product_details) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product in this id! '
            ];
        }


        $normal_product_details->price = $request->price;
        $normal_product_details->serial = $request->serial;
        $normal_product_details->model_number = $request->modelNumber;
        $normal_product_details->barcode = $request->barcode;
        $normal_product_details->discount = $request->discount;
        $normal_product_details->stock = $request->stock;
        $normal_product_details->discount_type = $request->discount_type;

        if ($normal_product_details->save()) {
            // check save success
            return [
                'status' => true,
                'data' => [
                    'normalProductDetails' => $normal_product_details
                ],
                'msg' => 'Data updated successfully done',
            ];
        }

    }


    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateProductOptionValues($id, Request $request)
    {

        // validation products
        $validation_productOptionValues = [
            'price' => 'required',
            'serial' => 'required',
            'modelNumber' => 'required',
            'barcode' => 'required',
            'discount' => 'required',
            'stock' => 'required',
        ];

        $validation = validator($request->all(), $validation_productOptionValues);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }
        $product_option_values = ProductOptionValues::where('product_id', $id)->first();


        if (!$product_option_values) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no product in this id! '
            ];
        }


        $product_option_values->price = $request->price;
        $product_option_values->serial = $request->serial;
        $product_option_values->model_number = $request->modelNumber;
        $product_option_values->barcode = $request->barcode;
        $product_option_values->discount = $request->discount;
        $product_option_values->stock = $request->stock;

        if ($product_option_values->save()) {

            $product_option_values_id = ProductOptionValues::where('product_id', $id)->first()->id;

            $product_option_values_details = ProductOptionValuesDetails::where('product_option_value_id', $product_option_values_id)->first();

            $option_value_id = OptionValues::first()->id;

            $product_option_values_details->option_value_id = $option_value_id;

            // check save success
            return [
                'status' => true,
                'data' => [
                    'normalProductDetails' => $product_option_values
                ],
                'msg' => 'Data updated successfully done',
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

        $productOptionValue = ProductOptionValues::where('product_id', $id)->first();

        //delete productTrans
        $product->productTrans()->delete();

        //delete productOptionValue
        $product->productOptionValue()->delete();

        //delete normalProductDetails
        $product->normalProductDetails()->delete();

        //delete productOptionValueDetails
        $productOptionValue->productOptionValueDetails()->delete();

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
