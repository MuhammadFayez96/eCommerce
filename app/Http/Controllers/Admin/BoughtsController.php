<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
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
      * optionDependentFetch function to get values for options
      * @return $output
      */
    public function optionDependentFetch(Request $request)
    {
        // get value option from request
        $value = $request->get('value');

        // get optionValues where option_id equal $value
        $options = OptionValues::where('option_id', $value)->get();

        // string of html
        $output = '<option value=""></option>';

        // append translted options to get value
        foreach ($options as $value) {

            //get option_value details
            $value->en = $value->translate('en');

            // append the value to output string
            $output .= '<option value="'.$value->en->value.'">'.$value->en->value.'</option>';
        }

        // print the result into output
        echo $output;
    }


    /**
      * createNewBought function
      *  @param Request request
      *  @return array
      */
    public function createNewBought(Request $request)
    {
        $role_id = $request->role_id;
        $user_id = User::where('role_id',$role_id)->first()->id;
        $product_id = $request->product_id;
        $option_id = $request->option_id;

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
