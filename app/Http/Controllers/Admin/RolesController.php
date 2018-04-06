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
        // append translated roles to all countries
        foreach ($roles as $role) {

            // get role details
            $role_translated = $role->translate();

            // add the translated role as a key => value to main role object
            // key is role_translated and the value id $role_details
            $role->role_translated = $role_translated;
        }
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
            'role_description_en' => 'required',
            'role_notes_en' => 'required',
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

        // choose one language to be the default one, let's make EN is the default
        // store master role
        // store the role in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Role - master
        $role = Role::forceCreate([
            'role' => $request->role
        ]);


        // check saving success
        if (!$role->save()) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }

        $role_en = null;
        if ($request->role_displayName_en && $request->role_description_en && $request->role_notes_en) {
            // store en version
            $role_en = $role->roleTrans()->create([
                'displayName' => $request->role_displayName_en,
                'description' => $request->role_description_en,
                'notes' => $request->role_notes_en,
                'lang_id' => $en_id
            ]);
        }
        // check saving status
        if (!$role_en) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong while saving EN, please try again!'
            ];
        }

        $role_ar = null;
        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->role_displayName_ar && $request->role_description_ar && $request->role_notes_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $role_ar = $role->roleTrans()->create([
                'displayName' => $request->role_displayName_ar,
                'description' => $request->role_description_ar,
                'notes' => $request->role_notes_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$role_ar) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

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

        // get role details
        $role_translated = $role->translate();

        $role->role_translated = $role_translated;

        return view('admin.pages.roles.edit-role', compact('role', 'role_translated'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateRole($id, Request $request)
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //role find by id
        $role = Role::find($id);

        //check if no role
        if (!$role) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no role with this id!'
            ];
        }

        $role->role = $request->role;

        //check save status
        if ($role->save()) {

            $role_en = $role->translate(1);
            $role_en->displayName = $request->role_displayName_en;
            $role_en->description = $request->role_description_en;
            $role_en->notes = $request->role_notes_en;

            //check if not save successfully
            if (!$role_en->save()) {
                //check save status
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->role_displayName_ar && $request->role_description_ar && $request->role_notes_ar) {

                $role_ar = $role->translate(2);
                $role_ar->displayName = $request->role_displayName_ar;
                $role_ar->description = $request->role_description_ar;
                $role_ar->notes = $request->role_notes_ar;

                //check if not save successfully
                if (!$role_ar->save()) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while saving AR, please try again!'
                    ];
                }
            }
            //check success status
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

        //delete user
        $role->user()->delete();

        //delete roleTrans
        $role->roleTrans()->delete();

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
