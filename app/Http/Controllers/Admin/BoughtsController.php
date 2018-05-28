<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductOptionValues;
use App\Models\Option;
use App\Models\OptionValues;
use App\Models\ProductTranslation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
  * class BoughtController
  * @package App/Http/Controllers/Admin
  */
class BoughtsController extends Controller
{
    /**
      * getIndex function
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
    public function getIndex()
    {
        return view('admin.pages.boughts.index');
    }

    /**
      * getCreateNewBought function
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
    public function getCreateNewBought(Request $request)
    {
        // get role where role = vendor
        $role = Role::where('role','vendor')->first();

        // get all products
        $products = Product::all();

        // append translated products
        foreach ($products as $product) {

            // get product details
            $product->trans = $product->translate();
        }

        // get all Options
        $options = Option::all();

        // append translated option
        foreach ($options as $option) {

            // get option details
            $option->trans = $option->translate();
            $option->values = $option->optionValues;

            foreach($option->values as $value) {
                $value->trans = $value->translate();
            }

        }

        return view('admin.pages.boughts.add-bought',compact('role','products','options'));
    }


    /**
      * getBoughtSectionView function
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
    public function getBoughtSectionView()
    {
        // get all products
        $products = Product::all();

        // append translated products
        foreach ($products as $product) {

            // get product details
            $product->trans = $product->translate();
        }

        // get all Options
        $options = Option::all();

        // append translated option
        foreach ($options as $option) {

            // get option details
            $option->trans = $option->translate();
            $option->values = $option->optionValues;

            foreach($option->values as $value) {
                $value->trans = $value->translate();
            }

        }

        return view('admin.pages.boughts.templates.bought-section', compact('products', 'options'))->render();
    }

    /**
      * getOptionSectionView function
      * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
    public function getOptionSectionView()
    {
        // get all Options
        $options = Option::all();

        // append translated option
        foreach ($options as $option) {

            // get option details
            $option->trans = $option->translate();
            $option->values = $option->optionValues;

            foreach($option->values as $value) {
                $value->trans = $value->translate();
            }

        }

        return view('admin.pages.boughts.templates.option-section',compact('options'))->render();
    }

    /**
    * get option's values
    */
    public function getOptionValues($id) {

        $values = Option::find($id)->optionValues;

        foreach ($values as $value) {

            $value->trans = $value->translate();
        }

        return view('admin.pages.boughts.templates.option-values',compact('values'))->render();

    }

    /**
      * createNewBought function
      *  @param Request request
      *  @return array
      */
    public function createNewBought(Request $request)
    {
        $validation_boughts = [

        ];

        $validation = validator($request->all(), $validation_boughts);

        if($validation->fails()){
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation_error'
            ];
        }



        $normal_products = $request->normal_products;
        $option_products = $request->option_products;

        if ($normal_products && $option_products){

            foreach ($normal_products as $key => $pro_normal) {

                $product_id =$normal_products[$key][0]['id'];

                $product = Product::find($product_id);

                if(!$product){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no product with such id!'
                    ];
                }

                $normal_products_details = $product->normalProductDetails()->forceCreate([
                    'product_id' => $product_id,
                    'discount_type' => $normal_products[$key][0]['discount_type'],
                    'price' => $normal_products[$key][0]['price'],
                    'serial' => $normal_products[$key][0]['serial'],
                    'model_number' => $normal_products[$key][0]['model_number'],
                    'barcode' => $normal_products[$key][0]['barcode'],
                    'discount' => $normal_products[$key][0]['discount'],
                    'stock' => $normal_products[$key][0]['stock'],
                ]);

                if(!$normal_products_details){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is somthing wrong please try again!'
                    ];
                }
            }


            foreach ($option_products as $option_key => $pro_option) {

                $total = 0;

                $options_array = $option_products[$option_key][0]['options_array'];

                foreach ($options_array[0]['prices'] as $k => $opts_array) {
                    $prices = $opts_array;
                    $total += $prices;
                }

                $product_id =$option_products[$option_key][0]['id'];

                $product = Product::find($product_id);

                if(!$product){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no product with such id!'
                    ];
                }

                $product_option_value = $product->productOptionValue()->forceCreate([
                    'product_id' => $product_id,
                    'price' => $total,
                    'serial' => $option_products[$option_key][0]['serial'],
                    'model_number' => $option_products[$option_key][0]['model_number'],
                    'barcode' => $option_products[$option_key][0]['barcode'],
                    'discount' => $option_products[$option_key][0]['discount'],
                    'stock' => $option_products[$option_key][0]['stock'],
                ]);

                if(!$product_option_value){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is somthing wrong please try again!!'
                    ];
                }

                $product_option_value_id = $product_option_value->id;

                $product_option_values = ProductOptionValues::find($product_option_value_id);

                if(!$product_option_values){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no option values with such id!'
                    ];
                }

                $options_array = $option_products[$option_key][0]['options_array'];

                foreach ($options_array[0]['option_values'] as $opt_key => $opt_array) {

                    foreach ($opt_array as $key => $v) {

                        $product_option_values->productOptionValueDetails()->forceCreate([
                        'option_value_id' => $v,
                        'product_option_value_id' => $product_option_value_id
                        ]);
                    }
                }
            }

        }else if($option_products){

            foreach ($option_products as $option_key => $pro_option) {

                $total = 0;

                $options_array = $option_products[$option_key][0]['options_array'];

                foreach ($options_array[0]['prices'] as $k => $opts_array) {
                    $prices = $opts_array;
                    $total += $prices;
                }

                $product_id =$option_products[$option_key][0]['id'];

                $product = Product::find($product_id);

                if(!$product){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no product with such id!'
                    ];
                }

                $product_option_value = $product->productOptionValue()->forceCreate([
                    'product_id' => $product_id,
                    'price' => $total,
                    'serial' => $option_products[$option_key][0]['serial'],
                    'model_number' => $option_products[$option_key][0]['model_number'],
                    'barcode' => $option_products[$option_key][0]['barcode'],
                    'discount' => $option_products[$option_key][0]['discount'],
                    'stock' => $option_products[$option_key][0]['stock'],
                ]);

                if(!$product_option_value){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is somthing wrong please try again!!'
                    ];
                }

                $product_option_value_id = $product_option_value->id;

                $product_option_values = ProductOptionValues::find($product_option_value_id);

                if(!$product_option_values){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no option values with such id!'
                    ];
                }

                $options_array = $option_products[$option_key][0]['options_array'];

                foreach ($options_array[0]['option_values'] as $opt_key => $opt_array) {

                    foreach ($opt_array as $key => $v) {

                        $product_option_values->productOptionValueDetails()->forceCreate([
                        'option_value_id' => $v,
                        'product_option_value_id' => $product_option_value_id
                        ]);
                    }
                }
            }

        }else if($normal_products){

            foreach ($normal_products as $key => $pro_normal) {

                $product_id =$normal_products[$key][0]['id'];

                $product = Product::find($product_id);

                if(!$product){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is no product with such id!'
                    ];
                }

                $normal_products_details = $product->normalProductDetails()->forceCreate([
                    'product_id' => $product_id,
                    'discount_type' => $normal_products[$key][0]['discount_type'],
                    'price' => $normal_products[$key][0]['price'],
                    'serial' => $normal_products[$key][0]['serial'],
                    'model_number' => $normal_products[$key][0]['model_number'],
                    'barcode' => $normal_products[$key][0]['barcode'],
                    'discount' => $normal_products[$key][0]['discount'],
                    'stock' => $normal_products[$key][0]['stock'],
                ]);

                if(!$normal_products_details){
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'There is somthing wrong please try again!'
                    ];
                }
            }
        }

        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Bought`s has been created successfully!'
        ];
    }

    /**
     * getUpdateBought function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateBought()
    {
        return view('admin.pages.boughts.edit-bought');
    }

    /**
      * updateBought function
      * @param Request $request
      * @param $id
      * @return array
      */
      public function updateBought(Request $request, $id)
      {

      }


    /**
      * deleteBought function
      * @param $id
      * @return array
      */
      public function deleteBought($id)
      {

      }

}
