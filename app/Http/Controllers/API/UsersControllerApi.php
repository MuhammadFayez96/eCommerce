<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class UsersController
 * @package App\Http\Controllers\API
 */
class UsersControllerApi extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //show 15 users from users table in db
        $users = User::paginate(15);

        //show all users from roles in db
        $roles = Role::all();

        // check if status is true
        return [
            'status' => true,
            'data' => [
                'users' => $users,
                'roles' => $roles
            ],
            'msg' => 'Data had been successfully displayed!'
        ];
    }


    public function getCreateNewUser()
    {
        //show all users from roles in db
        $roles = Role::all();

        // check if status is true
        return [
            'status' => true,
            'data' => [
                'roles' => $roles
            ],
            'msg' => 'Data had been successfully displayed!'
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewUser(Request $request)
    {
        // validation users
        $validation_users = [
            'name' => 'required|min:2|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'address_1' => 'required|min:2',
            'address_2' => 'required|min:2',
            'mobile' => 'required|min:11|numeric',
            'phone' => 'required|min:10|numeric',
            'gender' => 'required',
            'postal_code' => 'required',
            'notes' => 'required',
        ];

        $validation = validator($request->all(), $validation_users);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        //get role_id from request
        $role_id = $request->role_id;

        //get role
        $role = Role::find($role_id);

        //check if no role
        if (!$role) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no role with such id!'
            ];
        }

        //save data from request
        $user = User::forceCreate([
            'role_id' => $role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'postal_code' => $request->postal_code,
            'notes' => $request->notes,
        ]);

        //check if no user
        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user with such id!',
            ];
        }


        // check save status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'User has been created successfully!',
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateUser($id)
    {
        //find user by id
        $user = User::find($id);

        if(!$user)
        {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user with such id!'
            ];
        }

        //find role_id
        $role_id = $user->role_id;

        //find role by id
        $role = Role::find($role_id);

        if(!$role)
        {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no role with such id!'
            ];
        }

        //find all roles
        $roles = Role::all();

        // check if status is true
        return [
            'status' => true,
            'data' => [
                'user' => $user,
                'roles' => $roles,
                'role' => $role
            ],
            'msg' => "Data had been successfully displayed!"
        ];

    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateUser($id, Request $request)
    {
        // validation users
        $validation_users = [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'address_1' => 'required|min:2',
            'address_2' => 'required|min:2',
            'mobile' => 'required|min:11|numeric',
            'phone' => 'required|min:10|numeric',
            'gender' => 'required',
            'postal_code' => 'required',
            'notes' => 'required',
        ];

        $validation = validator($request->all(), $validation_users);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        //find user by id
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->mobile = $request->mobile;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->postal_code = $request->postal_code;
        $user->notes = $request->notes;


        //if no user
        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is No user in such id!'
            ];
        }

        if($user->save()){
        // check save status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'User has been Updated successfully!'
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteUser($id)
    {
        //find user by id
        $user = User::find($id);

        //check if no user
        if (!$user) {
            //check status
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is No user in such id!',
            ];
        }

        //delete user
        $user->delete();

        //check delete successfully
        return [
            'status' => true,
            'data' => null,
            'msg' => 'User has been deleted successfully!',
        ];
    }
}
