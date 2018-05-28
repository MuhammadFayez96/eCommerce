<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CategoriesController
 * @package App\Http\Controllers\API
 */
class CategoriesControllerApi extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //get all category from db
        $categories = Category::orderBy('parent_id')->get([
            'id', 'menu_id', 'parent_id'
        ]);

        // append translated category to all categories
        foreach ($categories as $category) {
            // get category details
            $category_translated = $category->translate();

            // add the translated Category as a key => value to main Category object
            // key is category_translated and the value id $category_translated
            $category->category_translated = $category_translated;
        }

        $menus = Menu::all();

        // append translated menu to all menus
        foreach ($menus as $menu) {
            // get menu details
            $menu_translated = $menu->translate();

            // add the translated menu as a key => value to main menu object
            // key is menu_translated and the value id $menu_translated
            $menu->menu_translated = $menu_translated;
        }

        return [
            'status' => true,
            'data' => [
                'categories' => $categories,
                'menus' => $menus
            ],
            'msg' => 'Data hsd been successfully displayed!'
        ];
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewCategory()
    {
        $menus = Menu::all();

        $main_categories = Category::where('parent_id', 0)->get();

        // append translated menu to all menus
        foreach ($menus as $menu) {
            // get menu details
            $menu->menu_translated = $menu->translate();
        }

        //append translated category to all main categories
        foreach ($main_categories as $category) {

            $category->trans = $category->translate();
        }

        return [
            'status' => true,
            'data' =>[
                'menus' => $menus,
                'main_categories' => $main_categories
            ],
            'msg' => 'Data had been successfully displayed!'
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewCategory(Request $request)
    {
        // validation category
        $validation_rules = [
            'category_en' => 'required',
            'description_en' => 'required',
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

        // choose one language to be the default one, let's make EN is the default
        // store master category
        // store the category in en
        $en_id = Language::where('lang_code', 'en')->first()->id;


        $main_category = null;
        $menu = null;
        if ($request->category_type == 'sub') {

            $main_category = Category::find($request->main_category_id);
            $menu = $main_category->menu;

            //store data in category
            $category = Category::forceCreate([
                'menu_id' => $menu->id,
                'parent_id' => $main_category->id,
            ]);

        } else {

            //store data in category
            $category = Category::forceCreate([
                'menu_id' => $request->menu_id,
                'parent_id' => 0,
            ]);

        }

        // store en version
        $category_en = $category->categoryTrans()->create([
            'category' => $request->category_en,
            'description' => $request->description_en,
            'notes' => $request->notes_en,
            'lang_id' => $en_id,
        ]);

        // check saving status
        if (!$category_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request,
        // then save it, else {no problem, not required}
        $category_ar = null;
        if ($request->category_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $category_ar = $category->categoryTrans()->create([
                'category' => $request->category_ar,
                'description' => $request->description_ar,
                'notes' => $request->notes_ar,
                'lang_id' => $ar_id,
            ]);
        }

        // check saving success
        return [
            'status' => true,
            'data' => null,
            'msg' => 'category was successfully created!',
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateCategory($id)
    {
        //find category by id
        $category = Category::find($id);

        if(!$category)
        {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is No category in such id!'
            ];
        }

        //get category details
        $category_translated_en = $category->translate('en');

        // add the translated category as a key => value to main category object
        // key is category_translated and the value id $category_translated
        $category->en = $category_translated_en;

        //get category details
        $category_translated_ar = $category->translate('ar');

        // add the translated category as a key => value to main category object
        // key is category_translated and the value id $category_translated
        $category->ar = $category_translated_ar;

        //get all menus
        $menus = Menu::all();

        // append translated menu to all menus
        foreach ($menus as $menu) {
            // get menu details
            $menu_translated = $menu->translate();

            // add the translated menu as a key => value to main menu object
            // key is menu_translated and the value id $menu_translated
            $menu->menu_translated = $menu_translated;
        }

        $main_categories = Category::where('parent_id', 0)->get();

        //append translated category to all main categories
        foreach ($main_categories as $key => $main_category) {

            $main_category->trans = $main_category->translate();

            if ($category->id == $main_category->id) {

                unset($main_categories[$key]);
            }
        }

        return [
            'status' => true,
            'data' => [
                'category' => $category,
                'menus' => $menus,
                'main_categories' => $main_categories
            ],
            'msg' => 'Data had been successfully displayed!'
        ];
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateCategory($id, Request $request)
    {
        // validation category
        $validation_rules = [
            'category_en' => 'required',
            'description_en' => 'required',
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
        //search category by id
        $category = Category::find($id);

        //check if no category
        if (!$category) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with this id!'
            ];
        }



        $main_category = null;
        $menu = null;
        if ($request->category_type == 'sub') {

            $main_category = Category::find($request->main_category_id);
            $menu = $main_category->menu;

            $category->parent_id = $main_category->id;
            $category->menu_id = $menu->id;
            $category->save();

        } else {

            $category->parent_id = 0;
            $category->menu_id = $request->menu_id;
            $category->save();
        }

        $category_en = $category->translate('en');

        $category_en->category = $request->category_en;
        $category_en->description = $request->description_en;
        $category_en->notes = $request->notes_en;

        // check save status
        if (!$category_en->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while updating EN, please try again!'
            ];
        }

        $category_ar = $category->translate('ar');

        $category_ar->category = $request->category_ar;
        $category_ar->description = $request->description_ar;
        $category_ar->notes = $request->notes_ar;
        $category_ar->save();

        // check save success
        return [
            'status' => true,
            'data' => null,
            'msg' => 'category was updated successfully!',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteCategory($id)
    {
        //search category by id
        $category = Category::find($id);

        // check if no category
        if (!$category) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with this id!!'
            ];
        }

        //find product by category_id
        $product = Product::where('category_id', $id)->first();

        //delete data from categoryTrans
        $category->categoryTrans()->delete();

        // //delete data from products
        // $category->products()->delete();
        //
        // //delete data from products
        // $product->productTrans()->delete();

        //delete data from category
        $category->delete();

        //check successfully deleted data
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Categories has been Deleted Successfully!'
        ];
    }

}
