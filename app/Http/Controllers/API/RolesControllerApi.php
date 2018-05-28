<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class RolesController
 * @package App\Http\Controllers\API
 */
class RolesControllerApi extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        // get all roles from db
        $roles = Role::all();

        foreach ($roles as $role) {
            $role->en = $role->translate('en');
            $role->ar = $role->translate('ar');
        }

        // check if status is true
        return [
            'status' => true,
            'data' => [
                'roles' => $roles
            ],
            'msg' => 'Role has been successfully displayed!'
        ];
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewRole()
    {
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Role has been successfully displayed!'
        ];
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
            'role_description_en' => 'required',
            'role_notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_roles);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master role
        // store the role in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Role - master
        $role = Role::forceCreate([
            'role' => $request->role
        ]);

        $role_en = $role->roleTrans()->create([
            'displayName' =>$request->role_displayName_en,
            'description' =>$request->role_description_en,
            'notes' =>$request->role_notes_en,
            'lang_id' => $en_id
        ]);

        $role_ar = null;

        if($request->role_displayName_ar)
        {
            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $role_ar = $role->roleTrans()->create([
                'displayName' =>$request->role_displayName_ar,
                'description' =>$request->role_description_ar,
                'notes' =>$request->role_notes_ar,
                'lang_id' => $ar_id
            ]);
        }

        //check success status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Role has been inserted successfully!',
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

        // check if no role in such id
        if(!$role)
        {
            return [
                'status' => true,
                'data' => null,
                'msg' => 'There is no role with such id!'
            ];

        }

        $role->en = $role->translate('en');
        $role->ar = $role->translate('ar');

        // check if status is true
        return [
            'status' => true,
            'data' => [
                'role' => $role
            ],
            'msg' => 'Role has been successfully displayed'
        ];
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
            'role_description_en' => 'required',
            'role_notes_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_roles);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        //role find by id
        $role = Role::find($request->role_id);

        //check if no role
        if (!$role) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no role with this id!'
            ];
        }

        $en_id = Language::where('lang_code', 'en')->first()->id;

        $role->update([
            'role' => $request->role
        ]);

        $role_en = $role->translate('en')->update([
            'displayName' => $request->role_displayName_en,
            'description' => $request->role_description_en,
            'notes' => $request->role_notes_en,
            'lang_id' => $en_id,
        ]);


        $role_ar = null;

        if($request->role_displayName_ar)
        {
            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $role_ar = $role->translate('ar')->update([
                'displayName' => $request->role_displayName_ar,
                'description' => $request->role_description_ar,
                'notes' => $request->role_notes_ar,
                'lang_id' => $ar_id,
            ]);
        }

        //check success status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Role has been updated successfully!',
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
                'status' => false,
                'data' => null,
                'msg' => 'There is no role is such id!'
            ];
        }

        // delete details for role
        $role->roleTrans()->delete();

        //delete role
        $role->delete();

        //check success status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Role has been deleted successfully!',
        ];
    }
}
