<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class MenusController
 * @package App\Http\Controllers\API
 */
class MenusController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getMenu($id)
    {
        //find menu by id
        $menu = Menu::find($id);

        //check if no menu
        if (!$menu) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no menu with this id!'
            ];
        }

        $menu_translated = $menu->translate();
        $menu->menu_translated = $menu_translated;


        //check success display data
        return [
            'status' => true,
            'data' => [
                'menu' => $menu,
            ],
            'msg' => 'Display Menu successfully done!!'
        ];
    }

    /**
     * @return array
     */
    public function getAllMenus()
    {
        //get all menus in db
        $menus = Menu::all();

        //check if no menus
        if (count($menus) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no menus with this id!!'
            ];
        }

        // append translated menu to all menus
        foreach ($menus as $menu) {

            // get menu details
            $menu_translated = $menu->translate();

            // add the translated menu as a key => value to main menu object
            // key is menu_translated and the value id $menu_translated
            $menu->menu_translated = $menu_translated;
        }

        //check successfully display all data
        return [
            'status' => true,
            'data' => [
                'Menus' => $menus,
            ],
            'msg' => 'Display All Menus'
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewMenu(Request $request)
    {
        // validation menus
        $validation_menus = [
            'description_en' => 'required',
            'notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_menus);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
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
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $menu_en = $menu->menuTrans()->create([
            'description' => $request->description_en,
            'notes' => $request->notes_en,
            'lang_id' => $en_id,
        ]);

        // check saving status
        if (!$menu_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->description_ar && $request->notes_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $menu_ar = $menu->menuTrans()->create([
                'description' => $request->description_ar,
                'notes' => $request->notes_ar,
                'lang_id' => $ar_id,
            ]);

            // check save status
            if (!$menu_ar) {
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
                'menu' => $menu,
                'menuTrans' => $menu->menuTrans()->getResults()
            ],
            'msg' => 'Data inserted successfully done',
        ];
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateMenu($id, Request $request)
    {
        // validation menus
        $validation_menus = [
            'description_en' => 'required',
            'notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_menus);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }
        //search menu by id
        $menu = Menu::find($id);

        //check if no option
        if (!$menu) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no menu with this id!'
            ];
        }

        //check save success
        if ($menu->save()) {

            $menu_en = $menu->translate(1);
            $menu_en->description = $request->description_en;
            $menu_en->notes = $request->notes_en;

            // check save status
            if (!$menu_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->description_ar && $request->notes_ar) {

                $menu_ar = $menu->translate(2);
                $menu_ar->description = $request->description_ar;
                $menu_ar->notes = $request->notes_ar;


                // check save status
                if (!$menu_ar->save()) {
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
                    'menu' => $menu
                ],
                'msg' => 'Data updated successfully done',
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteMenu($id)
    {
        //search option by id
        $menu = Menu::find($id);

        // check if no option
        if (!$menu) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no menu with this id!!'
            ];
        }

        //delete data from optionTrans
        $menu->menuTrans()->delete();

        //delete data from option
        $menu->delete();

        //check successfully deleted data
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Data Deleted Successfully!'
        ];
    }
}
