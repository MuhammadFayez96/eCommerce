<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CategoriesController
 * @package App\Http\Controllers\Admin
 */
class CategoriesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
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

        $menus = Menu::all();

        // append translated menu to all menus
        foreach ($menus as $menu) {
            // get menu details
            $menu_translated = $menu->translate();

            // add the translated menu as a key => value to main menu object
            // key is menu_translated and the value id $menu_translated
            $menu->menu_translated = $menu_translated;
        }

        return view('admin.pages.categories.index', compact('categories', 'menus'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewCategory()
    {
        $menus = Menu::all();

        // append translated menu to all menus
        foreach ($menus as $menu) {
            // get menu details
            $menu_translated = $menu->translate();

            // add the translated menu as a key => value to main menu object
            // key is menu_translated and the value id $menu_translated
            $menu->menu_translated = $menu_translated;
        }

        return view('admin.pages.categories.add-category',compact('menus'));
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
            'category_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
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

        // choose one language to be the default one, let's make EN is the default
        // store master category
        // store the category in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        //get menu from request
        $menu_id = $request->menu_id;

        //find menu by id
        $menu = Menu::find($menu_id);

        //if no menu
        if (!$menu) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no menu with such id!'
            ];
        }

        //store data in category
        $category = Category::forceCreate([
            'menu_id' => $menu_id,
            'parent_id' => '1',
        ]);


        // check saving success
        if (!$category->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }

        $category_en = null;
        if ($request->category_en) {
            // store en version
            $category_en = $category->categoryTrans()->create([
                'category' => $request->category_en,
                'description' => $request->description_en,
                'notes' => $request->notes_en,
                'lang_id' => $en_id,
            ]);
        }

        // check saving status
        if (!$category_en) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong while saving EN, please try again!'
            ];
        }

        $category_ar = null;
        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->category_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $category_ar = $category->categoryTrans()->create([
                'category' => $request->category_ar,
                'description' => $request->description_ar,
                'notes' => $request->notes_ar,
                'lang_id' => $ar_id,
            ]);

            // check save status
            if (!$category_ar) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data inserted successfully done',
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

        return view('admin.pages.categories.edit-category', compact('category', 'menus'));
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
            'category_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
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
        //search category by id
        $category = Category::find($id);

        //check if no category
        if (!$category) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no category with this id!'
            ];
        }

        // get menu from request
        $menu_id = $request->menu_id;

        //find menu by id
        $menu = Menu::find($menu_id);

        //check if no menu
        if (!$menu) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no menu with such id!'
            ];
        }

        //store menu_id in category
        $category->menu_id = $menu_id;

        //check save success
        if ($category->save()) {

            $category_en = $category->translate('en');

            $category_en->category = $request->category_en;
            $category_en->description = $request->description_en;
            $category_en->notes = $request->notes_en;

            // check save status
            if (!$category_en->save()) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->category_ar) {

                $category_ar = $category->translate('ar');

                $category_ar->category = $request->category_ar;
                $category_ar->description = $request->description_ar;
                $category_ar->notes = $request->notes_ar;

                // check save status
                if (!$category_ar->save()) {
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
                'title' => 'success',
                'text' => 'Data updated successfully done',
            ];
        }
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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no category with this id!!'
            ];
        }

        //find product by category_id
        $product = Product::where('category_id', $id)->first();

        //delete data from categoryTrans
        $category->categoryTrans()->delete();

        //delete data from products
        $category->products()->delete();

        //delete data from products
        $product->productTrans()->delete();

        //delete data from category
        $category->delete();

        //check successfully deleted data
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data Deleted Successfully!'
        ];
    }
}
