<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\CategoriesControllerApi;

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
        $categories_api = new CategoriesControllerApi();

        $getIndex_api = $categories_api->getIndex();

        if($getIndex_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getIndex_api['msg']
            ];
        }

        return view('admin.pages.categories.index', $getIndex_api['data']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewCategory()
    {
        $categories_api = new CategoriesControllerApi();

        $getCreateNewCategory_api = $categories_api->getCreateNewCategory();

        if($getCreateNewCategory_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getCreateNewCategory_api['msg']
            ];
        }
        return view('admin.pages.categories.add-category', $getCreateNewCategory_api['data']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewCategory(Request $request)
    {
        $categories_api = new CategoriesControllerApi();

        $createNewCategory_api = $categories_api->createNewCategory($request);

        if($createNewCategory_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $createNewCategory_api['msg']
            ];
        }

        // check saving success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $createNewCategory_api['msg']
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateCategory($id)
    {
        $categories_api = new CategoriesControllerApi();

        $getUpdateCategory_api = $categories_api->getUpdateCategory($id);

        if($getUpdateCategory_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateCategory_api['msg']
            ];
        }

        return view('admin.pages.categories.edit-category', $getUpdateCategory_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateCategory($id, Request $request)
    {
        $categories_api = new CategoriesControllerApi();

        $updateCategory_api = $categories_api->updateCategory($id, $request);

        if($updateCategory_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateCategory_api['msg']
            ];
        }

        // check save success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $updateCategory_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteCategory($id)
    {
        $categories_api = new CategoriesControllerApi();

        $deleteCategory_api = $categories_api->deleteCategory($id);

        if($deleteCategory_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteCategory_api['msg']
            ];
        }

        //check successfully deleted data
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $deleteCategory_api['msg']
        ];
    }
}
