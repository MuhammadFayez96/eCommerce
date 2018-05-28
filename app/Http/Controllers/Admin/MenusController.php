<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\Menu;
use App\Models\MenuTranslation;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\MenusControllerApi;

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
        $menus_api = new MenusControllerApi();

        $getIndex_api = $menus_api->getIndex();

        if($getIndex_api['status'] == false)
        {
            return [
                'status' => 'erorr',
                'title' => 'Error',
                'text' => $getIndex_api['msg']
            ];
        }

        return view('admin.pages.menus.index', $getIndex_api['data']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewMenu()
    {
        $menus_api = new MenusControllerApi();

        $getCreateNewMenu_api = $menus_api->getCreateNewMenu();

        return view('admin.pages.menus.add-menu');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewMenu(Request $request)
    {
        $menus_api = new MenusControllerApi();

        $createNewMenu_api = $menus_api->createNewMenu($request);

        if($createNewMenu_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $createNewMenu_api['msg']
            ];
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $createNewMenu_api['msg']
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateMenu($id)
    {
        $menus_api = new MenusControllerApi();

        $getUpdateMenu_api = $menus_api->getUpdateMenu($id);

        if($getUpdateMenu_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateMenu_api['msg']
            ];
        }

        return view('admin.pages.menus.edit-menu', $getUpdateMenu_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateMenu(Request $request)
    {
        $menus_api = new MenusControllerApi();

        $updateMenu_api = $menus_api->updateMenu($request);

        if($updateMenu_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateMenu_api['msg']
            ];
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $updateMenu_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteMenu($id)
    {
        $menus_api = new MenusControllerApi();

        $deleteMenu_api = $menus_api->deleteMenu($id);

        if($deleteMenu_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteMenu_api['msg']
            ];
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $deleteMenu_api['msg']
        ];
    }
}
