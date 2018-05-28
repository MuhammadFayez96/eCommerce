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
class ProductsControllerApi extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get all products from db
        $products = Product::all();

        // append translated products to all countries
        foreach ($products as $product) {

            // get product details
            $product_translated = $product->translate();

            // add the translated product as a key => value to main product object
            // key is product_translated and the value id $product_details
            $product->product_translated = $product_translated;
        }

        // check successfully status
        return [
            'status' => true,
            'data' => [
                'products' => $products
            ],
            'msg' => 'Products was successfully displyed!'
        ];

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewProduct()
    {
        //get all category from db
        $categories = Category::all();

        // append translated category to all categories
        foreach ($categories as $category) {

            // get category details
            $category_translated = $category->translate();

            // add the translated Category as a key => value to main Category object
            // key is category_translated and the value id $category_translated
            $category->category_translated = $category_translated;
        }

        // check successfully status
        return [
            'status' => true,
            'data' =>[
                'categories' => $categories
            ],
            'msg' => 'Data was successfully displayed'
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
        $category_id = $request->category_id;

        //find category by id
        $category = Category::find($category_id);

        //check if no category
        if (!$category) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with such id!'
            ];
        }

        // stored data in product table
        $product = Product::forceCreate([
            'category_id' => $category_id,
            'type' => $request->type_en,
        ]);

        // check saving success
        if (!$product->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // set $product_en equal null
        $product_en = null;

        // check if request for name in language en
        if ( $request->name_en) {

            // store en version
            $product_en = $product->productTrans()->create([
                'name' => $request->name_en,
                'description' => $request->description_en,
                'notes' => $request->notes_en,
                'lang_id' => $en_id
            ]);
        }
        // check saving status
        if (!$product_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // set product_ar equal null
        $product_ar = null;

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ( $request->name_ar) {

            // store the product in ar
            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $product_ar = $product->productTrans()->create([
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

        //check successfully status
        return [
            'status' => true,
            'data' => [
                'product' => $product
            ],
            'msg' => 'Product has been successfully recorded',
        ];
    }


    /**
     * @param $id
     *  @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateProduct($id)
    {
        //find product by id
        $product = Product::find($id);

        if(!$product)
        {
            return [
                'status' => false,
                'data' =>null,
                'msg' => 'There is no product in such id!'
            ];
        }

        //product arabic translate details
        $product_translated_ar = $product->translate('ar');

        $product->ar = $product_translated_ar;

        //english product translate details
        $product_translated_en = $product->translate('en');

        $product->en = $product_translated_en;


        //get all category from db
        $categories = Category::all();

        if(count($categories) == 0)
        {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no Categories in db!'
            ];
        }

        // append translated category to all categories
        foreach ($categories as $category) {

            // get category details
            $category_translated = $category->translate();

            // add the translated Category as a key => value to main Category object
            // key is category_translated and the value id $category_translated
            $category->category_translated = $category_translated;
        }

        //check successfully status
        return [
            'status' => true,
            'data' => [
                'product' => $product,
                'categories' => $categories
            ],
            'msg' => 'Data was successfully displayed'
        ];
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateProduct($id, Request $request)
    {
        // validation products
        $validation_rules = [
            'type_en' => 'required',
            'name_en' => 'required',
            'description_en' => 'required',
            'notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_rules);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

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

        //store request category id
        $product->category_id = $request->category_id;
        $product->type = $request->type_en;

        //check save status
        if ($product->save()) {

            $product_en = $product->translate('en');
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

            if ($request->name_ar) {

                $product_ar = $product->translate('ar');
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
                'msg' => 'Product has been successfully updated!',
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

        // $productOptionValue = ProductOptionValues::where('product_id', $id)->first();

        //delete productOptionValueDetails
        // $productOptionValue->productOptionValueDetails()->delete();

        //delete productOptionValue
        // $product->productOptionValue()->delete();

        //delete normalProductDetails
        // $product->normalProductDetails()->delete();

        //delete productTrans
        $product->productTrans()->delete();

        //delete product
        $product->delete();

        //check  success status
        return [
            'status' => true,
            'data' => [
                'product' => $product
            ],
            'msg' => 'Product has been successfully deleted!'
        ];
    }

}
