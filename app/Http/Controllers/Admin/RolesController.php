<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\RolesControllerApi;

/**
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class RolesController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $roles_api = new RolesControllerApi();

        $getIndex_api = $roles_api->getIndex();

        return view('admin.pages.roles.index', $getIndex_api['data']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewRole()
    {
        $roles_api = new RolesControllerApi();

        $getCreateNewRole_api = $roles_api->getCreateNewRole();

        if($getCreateNewRole_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getCreateNewRole_api['msg']
            ];
        }

        return view('admin.pages.roles.add-role');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewRole(Request $request)
    {
        $roles_api = new RolesControllerApi();

        $createNewRole_api = $roles_api->createNewRole($request);

        if($createNewRole_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $createNewRole_api['msg']
            ];
        }


        //check success status
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $createNewRole_api['msg']
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateRole($id)
    {
        $roles_api = new RolesControllerApi();

        $getUpdateRole_api = $roles_api->getUpdateRole($id);

        if($getUpdateRole_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateRole_api['msg']
            ];
        }

        return view('admin.pages.roles.edit-role', $getUpdateRole_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateRole(Request $request)
    {
        $roles_api = new RolesControllerApi();

        $updateRole_api = $roles_api->updateRole($request);

        if($updateRole_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateRole_api['msg']
            ];
        }

        //check success status
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $updateRole_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteRole($id)
    {
        $roles_api = new RolesControllerApi();

        $deleteRole_api = $roles_api->deleteRole($id);

        if($deleteRole_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteRole_api['msg']
            ];
        }

        //check success status
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $deleteRole_api['msg']
        ];
    }
}
