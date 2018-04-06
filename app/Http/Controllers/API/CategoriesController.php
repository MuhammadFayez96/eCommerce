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
class CategoriesController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getCategory($id)
    {
        //search category by id
        $category = Category::find($id);

        //check if category not found
        if (!$category) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with this id!'
            ];
        }

        //get category details
        $category_translated = $category->translate();
        $category->category_translated = $category_translated;

        //check success display data
        return [
            'status' => true,
            'data' => [
                'option' => $category,
            ],
            'msg' => 'Display category successfully done!!'
        ];


    }

    /**
     * @return array
     */
    public function getAllCategories()
    {
        //get all category from db
        $categories = Category::all();

        //check if no Category
        if (count($categories) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with this id!!'
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

        //check successfully display all data
        return [
            'status' => true,
            'data' => [
                'categories' => $categories,
            ],
            'msg' => 'Display All Categories'
        ];

    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewCategory(Request $request)
    {
        // validation category
        $validation_categories = [
            'category_en' => 'required',
            'category_description_en' => 'required',
            'category_notes_en' => 'required',
            'menu_id' => 'required',
            'parent_id' => 'required',
        ];

        $validation = validator($request->all(), $validation_categories);

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

        $menu_id = $request->menu_id;
        //find menu by id
        $menu = Menu::find($menu_id);

        //if no menu
        if (!$menu) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no menu with such id!'
            ];
        }

        $category = Category::forceCreate([
            'menu_id' => $menu_id,
            'parent_id' => $request->parent_id
        ]);


        // check saving success
        if (!$category->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        $category_en = null;
        if ($request->description_en && $request->notes_en) {
            // store en version
            $category_en = $category->categoryTrans()->create([
                'category' => $request->category_en,
                'description' => $request->category_description_en,
                'notes' => $request->category_notes_en,
                'lang_id' => $en_id,
            ]);
        }

        // check saving status
        if (!$category_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        $category_ar = null;
        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->category_ar && $request->category_description_ar && $request->category_notes_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $category_ar = $category->categoryTrans()->create([
                'category' => $request->category_ar,
                'description' => $request->category_description_ar,
                'notes' => $request->category_notes_ar,
                'lang_id' => $ar_id,
            ]);

            // check save status
            if (!$category_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }


        // check saving success
        return [
            'status' => true,
            'data' => [
                'option' => $category,
                'optionTrans' => $category->categoryTrans()->getResults()
            ],
            'msg' => 'Data inserted successfully done',
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
        $validation_categories = [
            'category_en' => 'required',
            'category_description_en' => 'required',
            'category_notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_categories);

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

        //check save success
        if ($category->save()) {

            $category_en = $category->translate(1);

            $category_en->category = $request->category_description_en;
            $category_en->description = $request->category_description_en;
            $category_en->notes = $request->category_notes_en;

            // check save status
            if (!$category_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->category_ar && $request->category_description_ar && $request->category_notes_ar) {

                $category_ar = $category->translate(2);

                $category_ar->category = $request->category_ar;
                $category_ar->description = $request->category_description_ar;
                $category_ar->notes = $request->category_notes_ar;

                // check save status
                if (!$category_ar->save()) {
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
                    'category' => $category
                ],
                'msg' => 'Data updated successfully done',
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
                'status' => false,
                'data' => null,
                'msg' => 'There is no category with this id!!'
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
            'status' => true,
            'data' => null,
            'msg' => 'Data Deleted Successfully!'
        ];
    }
}
