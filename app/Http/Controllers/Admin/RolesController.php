<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class RolesController
 * @package App\Http\Controllers\Admin
 */
class RolesController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $roles = Role::all();

        return view('admin.pages.roles.index', compact('roles'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewRole()
    {
        return view('admin.pages.roles.add-role');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewRole(Request $request)
    {

        // validation roles
        $validation_roles = [
            'role' => 'required',
            'role_displayName_en' => 'required',
            'notes' => 'required',
        ];

        $validation = validator($request->all(), $validation_roles);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        // instantiate App\Model\Role - master
        $role = Role::forceCreate([
            'role' => $request->role,
            'display_name_en' => $request->role_displayName_en,
            'display_name_ar' => $request->role_displayName_ar,
            'notes' => $request->notes
        ]);

        //check success status
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
    public function getUpdateRole($id)
    {
        //find role by id
        $role = Role::find($id);

        return view('admin.pages.roles.edit-role', compact('role'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateRole(Request $request)
    {
        // validation roles
        $validation_roles = [
            'role' => 'required',
            'role_displayName_en' => 'required',
            'notes' => 'required',
        ];

        $validation = validator($request->all(), $validation_roles);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //role find by id
        $role = Role::find($request->role_id);

        //check if no role
        if (!$role) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no role with this id!'
            ];
        }

        $role->update([
            'role' => $request->role,
            'display_name_en' => $request->role_displayName_en,
            'display_name_ar' => $request->role_displayName_ar,
            'notes' => $request->notes
        ]);

        //check success status
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data updated successfully done',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteRole($id)
    {
        //find role by id
        $role = Role::find($id);

        //check if no role
        if (!$role) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no role is such id!'
            ];
        }

        //delete role
        $role->delete();

        //check success status
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data deleted successfully done',
        ];
    }
}
