<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UsersControllerApi;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $users_api = new UsersControllerApi();

        $getIndex_api = $users_api->getIndex();

        if($getIndex_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getIndex_api['msg']
            ];
        }

        //return view page index
        return view('admin.pages.users.index', $getIndex_api['data']);
    }


    public function getCreateNewUser()
    {
        $users_api = new UsersControllerApi();

        $getCreateNewUser_api = $users_api->getCreateNewUser();

        if($getCreateNewUser_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getCreateNewUser_api['msg']
            ];
        }

        return view('admin.pages.users.add-user', $getCreateNewUser_api['data']);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewUser(Request $request)
    {
        $users_api = new UsersControllerApi();

        $createNewUSer_api = $users_api->createNewUser($request);

        if($createNewUSer_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $createNewUSer_api['msg']
            ];
        }

        // check save status
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $createNewUSer_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateUser($id)
    {
        $users_api = new UsersControllerApi();

        $getUpdateUser_api = $users_api->getUpdateUser($id);

        if($getUpdateUser_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateUser_api['msg']
            ];
        }

        //return view edit-user page
        return view('admin.pages.users.edit-user', $getUpdateUser_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateUser($id, Request $request)
    {
        $users_api = new UsersControllerApi();

        $updateUser_api = $users_api->updateUser($id, $request);

        if($updateUser_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateUser_api['data']
            ];
        }

        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $updateUser_api['msg']
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteUser($id)
    {
        $users_api = new UsersControllerApi();

        $deleteUser_api = $users_api->deleteUser($id);

        if($deleteUser_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteUser_api['msg']
            ];
        }

        //check delete successfully
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $deleteUser_api['msg']
        ];
    }
}
