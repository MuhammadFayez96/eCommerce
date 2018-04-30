<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\Menu;
use App\Models\MenuTranslation;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MenusController
 * @package App\Http\Controllers\Admin
 */
class MenusController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //get all menus
        $menus = Menu::all();
        // append translated menu to all menus
        foreach ($menus as $menu) {

            // get menu details
            $menu->menu_translated = $menu->translate();
        }

        return view('admin.pages.menus.index', compact('menus'));
    }

    public function getCreateNewMenu()
    {
        return view('admin.pages.menus.add-menu');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewMenu(Request $request)
    {
        // validation menus
        $validation_menus = [
            'menu_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_menus);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master option
        // store the menu in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Menu - master
        $menu = new Menu;

        // check saving success
        if (!$menu->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $menu_en = $menu->menuTrans()->create([
            'menu' => $request->menu_en,
            'description' => $request->menu_description_en,
            'notes' => $request->menu_notes_en,
            'lang_id' => $en_id,
        ]);

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        $menu_ar = null;
        if ($request->menu_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $menu_ar = $menu->menuTrans()->create([
                'menu' => $request->menu_ar,
                'description' => $request->menu_description_ar,
                'notes' => $request->menu_notes_ar,
                'lang_id' => $ar_id,
            ]);
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Menu had been created successfully',
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateMenu($id)
    {
        //find menu by id
        $menu = Menu::find($id);
        //get menu details
        $menu->en = $menu->translate('en');
        $menu->ar = $menu->translate('ar');

        return view('admin.pages.menus.edit-menu', compact('menu'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateMenu(Request $request)
    {
        // validation menus
        $validation_menus = [
            'menu_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_menus);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        $menu_id = $request->id;
        //search menu by id
        $menu = Menu::find($menu_id);

        //check save success
        if ($menu) {

            $en_id = Language::where('lang_code', 'en')->first()->id;

            $menu_en = $menu->translate('en');
            $menu_en->menu = $request->menu_en;
            $menu_en->description = $request->menu_description_en;
            $menu_en->notes = $request->menu_notes_en;

            // check save status
            if (!$menu_en->save()) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while updating EN, please try again!'
                ];
            }

            $menu_ar = $menu->translate('ar');

            if ($menu_ar) {

                $menu_ar->menu = $request->menu_ar;
                $menu_ar->description = $request->menu_description_ar;
                $menu_ar->notes = $request->menu_notes_ar;

                $menu_ar->save();

            } else {

                if ($request->menu_ar) {

                    $ar_id = Language::where('lang_code', 'ar')->first()->id;
                    $menu_ar = new MenuTranslation;

                    $menu_ar->lang_id = $ar_id;
                    $menu_ar->menu_id = $menu->id;
                    $menu_ar->menu = $request->menu_ar;
                    $menu_ar->description = $request->menu_description_ar;
                    $menu_ar->notes = $request->menu_notes_ar;

                    $menu_ar->save();
                }

            }

            // check saving success
            return [
                'status' => 'success',
                'title' => 'success',
                'text' => "Menu\'s data was updated successfully",
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteMenu($id)
    {
        //find menu by id
        $menu = Menu::find($id);

        // check if no option
        if (!$menu) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no menu with this id!!'
            ];
        }

        //find category by menu_id
        $category = Category::where('menu_id', $id)->first();

        //get category_id from category by menu_id
//        $category_id = $category->id;

//        //find product by category_id
//        $product = Product::where('category_id', $category_id)->first();

        //delete data from categoryTrans
        $category->categoryTrans()->delete();

        //delete data from categories
        $menu->categories()->delete();

        //delete data from optionTrans
        $menu->menuTrans()->delete();

        //delete data from products
//        $category->products()->delete();

        //delete data from productTrans
//        $product->productTrans()->delete();

        //delete data from option
        $menu->delete();

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data deleted successfully done',
        ];
    }
}
