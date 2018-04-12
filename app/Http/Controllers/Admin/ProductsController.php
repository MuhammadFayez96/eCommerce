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

class ProductsController extends Controller
{
    public function getIndex()
    {
        $products = Product::all();

        // append translated products to all countries
        foreach ($products as $product) {

            // get product details
            $product_translated = $product->translate();

            // add the translated product as a key => value to main product object
            // key is product_translated and the value id $product_details
            $product->product_translated = $product_translated;
        }

        return view('admin.pages.products.index', compact('products'));
    }

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

        //get all option in db
        $options = Option::all();

        // append translated option to all options
        foreach ($options as $option) {

            // get option details
            $option_translated = $option->translate();

            // add the translated option as a key => value to main option object
            // key is option_translated and the value id $option_translated
            $option->option_translated = $option_translated;

        }

        return view('admin.pages.products.add-product', compact('categories', 'options','optionValues'));
    }

    public function createNewProduct(Request $request)
    {
        // validation products
        $validation_products = [
            'type_en' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'notes_en' => 'required',
            'notes_ar' => 'required',
        ];

        $validation = validator($request->all(), $validation_products);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no category with such id!'
            ];
        }


        $product = Product::forceCreate([
            'category_id' => $category_id,
            'type' => $request->type_en,
        ]);

        // check saving success
        if (!$product->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }
        $product_en = null;

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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong while saving EN, please try again!'
            ];
        }

        $product_ar = null;
        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ( $request->name_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $product_ar = $product->productTrans()->create([
                // 'type' => $request->type_en,
                'name' => $request->name_ar,
                'description' => $request->description_ar,
                'notes' => $request->notes_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$product_ar) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        //check successfully status
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => 'Data inserted successfully done',
        ];

    }

    public function createNewNormalProduct($id, Request $request)
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //get product_id
        $product_id = $id;


        //fiind product by id
        $product = Product::find($product_id);

        //check if no product
        if (!$product) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with such id!'
            ];
        }

        $normalProduct = NormalProductDetails::forceCreate([
            'product_id' => $product_id,
            'price' => $request->price,
            'serial' => $request->serial,
            'model_number' => $request->modelNumber,
            'barcode' => $request->barcode,
            'discount' => $request->discount,
            'stock' => $request->stock,
            'discount_type' => $request->discount_type,
        ]);

        //check save status
        if (!$normalProduct->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with this id!'
            ];
        }

        //check save status
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => 'Normal Product Data Inserted Successfully Done',
        ];
    }

    public function createNewProductOptionValues($id, Request $request)
    {
        // validation products
        $validation_productOptionValues = [
            'option_price' => 'required',
            'option_serial' => 'required',
            'option_model_number' => 'required',
            'option_barcode' => 'required',
            'option_discount' => 'required',
            'option_stock' => 'required',
        ];

        $validation = validator($request->all(), $validation_productOptionValues);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //get product_id
        $product_id = $id;

        //find product by id
        $product = Product::find($product_id);

        //check if no product
        if (!$product) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with such id!'
            ];
        }

        $productOptionValues = ProductOptionValues::forceCreate([
            'product_id' => $product_id,
            'price' => $request->option_price,
            'serial' => $request->option_serial,
            'model_number' => $request->option_model_number,
            'barcode' => $request->option_barcode,
            'discount' => $request->option_discount,
            'stock' => $request->option_stock,
        ]);;

        //check save status
        if (!$productOptionValues->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with this id!'
            ];
        }

        $option_value_id = $request->option_value_id;

        $option_value = OptionValues::find($option_value_id);

        //check save status
        if (!$option_value) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no option value with such id!'
            ];
        }

        $product_option_value_id = ProductOptionValues::where('product_id', $id)->first()->id;

        $productOptionValuesDetails = $productOptionValues->productOptionValueDetails()->forceCreate([
            'option_value_id' => $option_value_id,
            'product_option_value_id' => $product_option_value_id
        ]);

        //check save status
        if (!$productOptionValuesDetails->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with this id!'
            ];
        }

        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => 'Data Inserted Successfully Done',
        ];
    }


    public function getUpdateProduct($id)
    {
        //find product by id
        $product = Product::find($id);

        //product arabic translate details
        $product_translated_ar = $product->translate('ar');

        $product->ar = $product_translated_ar;

        //english product translate details
        $product_translated_en = $product->translate('en');

        $product->en = $product_translated_en;


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

        return view('admin.pages.products.edit-product', compact('product', 'categories'));
    }

    public function updateProduct($id, Request $request)
    {
        // validation products
        $validation_rules = [
            'type_en' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',
            'notes_en' => 'required',
            'notes_ar' => 'required',
        ];

        $validation = validator($request->all(), $validation_rules);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //find product by id
        $product = Product::find($id);

        //check if no product
        if (!$product) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product with this id!'
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
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while updating EN, please try again!'
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
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            // check save success
            return [
                'status' => 'success',
                'title' => 'Success',
                'text' => 'Data Updated Successfully Done!',
            ];
        }
    }

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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product in this id! '
            ];
        }


        $normal_product_details->price = $request->price;
        $normal_product_details->serial = $request->serial;
        $normal_product_details->model_number = $request->modelNumber;
        $normal_product_details->barcode = $request->barcode;
        $normal_product_details->discount = $request->discount;
        $normal_product_details->stock = $request->stock;
        $normal_product_details->discount_type = $request->discount_type;

        //check save status
        if ($normal_product_details->save()) {
            // check save success
            return [
                'status' => 'success',
                'title' => 'Success',
                'text' => 'Normal Option Data Updated Successfully Done!',
            ];
        }

    }

    public function updateProductOptionValues($id, Request $request)
    {
        // validation products
        $validation_productOptionValues = [
            'option_price' => 'required',
            'option_serial' => 'required',
            'option_model_number' => 'required',
            'option_barcode' => 'required',
            'option_discount' => 'required',
            'option_stock' => 'required',
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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no product in this id! '
            ];
        }


        $product_option_values->price = $request->option_price;
        $product_option_values->serial = $request->option_serial;
        $product_option_values->model_number = $request->option_model_number;
        $product_option_values->barcode = $request->option_barcode;
        $product_option_values->discount = $request->option_discount;
        $product_option_values->stock = $request->option_stock;

        if ($product_option_values->save()) {

            $option_value_id = $request->option_value_id;

            $product_option_value_id = ProductOptionValues::where('product_id', $id)->first()->id;

            $product_option_values_details = ProductOptionValuesDetails::where('product_option_value_id', $product_option_value_id)->first();

            $product_option_values_details->option_value_id = $option_value_id;

            if ($product_option_values_details->save()) {

                // check save success
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'text' => 'Data Updated Successfully Done!',
                ];
            }
        }

    }

    public function deleteProduct($id)
    {
        //search  for product
        $product = Product::find($id);

        //if no product
        if (!$product) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no Product with this id!'
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
            'status' => 'success',
            'title' => 'Success',
            'text' => 'Data is deleted successfully!'
        ];
    }
}
