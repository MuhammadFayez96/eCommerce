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
class RolesController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getRole($id)
    {
        //find role by id
        $role = Role::find($id);

        // if no role, return false status
        if (!$role) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no Role with this id!'
            ];
        }

        // get role details
        $role_translated = $role->translate();

        $role->role_translated = $role_translated;

        // check success status
        return [
            'status' => true,
            'data' => [
                'role' => $role,
            ],
            'msg' => 'successfully done!'
        ];

    }


    /**
     * @return array
     */
    public function getAllRoles()
    {
        //get All Roles
        $roles = Role::all();

        //check if no roles
        if (count($roles) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no roles exist in DB'
            ];
        }

        // append translated roles to all countries
        foreach ($roles as $role) {

            // get role details
            $role_translated = $role->translate();

            // add the translated role as a key => value to main role object
            // key is role_translated and the value id $role_details
            $role->role_translated = $role_translated;
        }

        //check success status
        return [
            'status' => true,
            'data' => [
                'roles' => $roles,
            ],
            'msg' => 'Display All Countries'
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


        // check saving success
        if (!$role->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
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
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
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
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        //check save status
        return [
            'status' => true,
            'data' => [
                'role' => $role,
                'roleTrans' => $role->roleTrans()->getResults()
            ],
            'msg' => 'Data inserted successfully done',
        ];
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
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        //find role by id
        $role = Role::find($id);

        //if no role
        if (!$role) {
            //check if no role
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no role with this id!'
            ];
        }


        $role->role = $request->role;

        //if role save successfully
        if ($role->save()) {

            $role_en = $role->translate(1);

            $role_en->displayName = $request->role_displayName_en;
            $role_en->description = $request->role_description_en;
            $role_en->notes = $request->role_notes_en;

            //check save status
            if (!$role_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->role_displayName_ar && $request->role_description_ar && $request->role_notes_ar) {

                $role_ar = $role->translate(2);

                $role_ar->displayName = $request->role_displayName_ar;
                $role_ar->description = $request->role_description_ar;
                $role_ar->notes = $request->role_notes_ar;

                //check save status
                if (!$role_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            //check success status
            return [
                'status' => true,
                'data' => [
                    'role' => $role
                ],
                'msg' => 'Data updated successfully done',
            ];
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteRole($id)
    {
        //search  for role
        $role = Role::find($id);

        //if no role
        if (!$role) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no Role with this id!'
            ];
        }

        //delete roleTrans
        $role->roleTrans()->delete();

        //delete role
        $role->delete();
        //check  success status
        return [
            'status' => True,
            'data' => null,
            'msg' => 'Data is deleted successfully!'
        ];
    }
}
