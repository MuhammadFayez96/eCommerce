<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //show 15 users from users table in db
        $users = User::paginate(15);
        //show all users from roles in db
        $roles = Role::all();
        //return view page index
        return view('admin.pages.users.index', compact('users', 'roles'));
    }


    public function getCreateNewUser()
    {
        //show all users from roles in db
        $roles = Role::all();

        return view('admin.pages.users.add-user', compact('roles'));
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //get role_id from request
        $role_id = $request->role_id;

        //get role
        $role = Role::find($role_id);

        //check if no role
        if (!$role) {
            return [
                'status' => 'error',
                'title' => 'no role',
                'text' => 'There is no role with such id!'
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
                'status' => 'error',
                'title' => 'no user',
                'text' => 'There id no user in such id!',
            ];
        }

        //check save state
        if ($user->save()) {
            // check save status
            return [
                'status' => 'success',
                'title' => 'Successful Saving',
                'text' => 'User Added successfully.',
            ];
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateUser($id)
    {
        //find user by id
        $user = User::find($id);
        //find role_id
        $role_id = $user->role_id;
        //find role by id
        $role = Role::find($role_id);
        //find all roles
        $roles = Role::all();

        //return view edit-user page
        return view('admin.pages.users.edit-user', compact('user', 'roles', 'role'));
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
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
                'status' => 'error',
                'title' => 'There is No user in such id!',
                'text' => 'Un Expected Error please try again',
            ];
        }

        // check save successfully state
        if ($user->save()) {
            // check save status
            return [
                'status' => 'success',
                'title' => 'Successfully updated',
                'text' => 'User Updated successfully.'
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
                'status' => 'error',
                'title' => 'There is No user in such id!',
                'text' => 'Un Expected Error please try again',
            ];
        }

        //delete user
        $user->delete();

        //check delete successfully
        return [
            'status' => 'success',
            'title' => 'Successful Deleting',
            'text' => 'User deleted successfully.',
        ];
    }
}
