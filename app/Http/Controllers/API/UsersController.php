<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersController
 * @package App\Http\Controllers\API
 */
class UsersController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user in such id!'
            ];
        }

        $user_bought = $user->details()->getResults();
        $user->user_bought = $user_bought;

        // check success status
        return [
            'status' => true,
            'data' => [
                'user' => $user,
            ],
            'msg' => 'successfully done!'
        ];
    }

    /**
     * @return array
     */
    public function getAllUsers()
    {
        $users = User::all();

        if (count($users) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user in such id!'
            ];
        }

        foreach ($users as $user) {

            $user_bought = $user->details()->getResults();

            $user->user_bought = $user_bought;

        }

        //check success status
        return [
            'status' => true,
            'data' => [
                'users' => $users,
            ],
            'msg' => 'Display All Users successfully done!'
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
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

        $user = User::forceCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address-1' => $request->address_1,
            'address-2' => $request->address_2,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'postal-code' => $request->postal_code,
            'notes' => $request->notes,
        ]);

        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user !'
            ];
        }

        if ($user->save()) {
            // check save status
            return [
                'status' => true,
                'data' => [
                    'user' => $user,
                ],
                'msg' => 'Data inserted successfully done!',
            ];
        }
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
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

        $user = User::find($id);
        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user in such id!'
            ];
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->mobile = $request->mobile;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->postal_code = $request->postal_code;
        $user->notes = $request->notes;

        if ($user->save()) {

            return [
                'status' => true,
                'data' => [
                    'user' => $user,
                ],
                'msg' => 'Data updated successfully done',
            ];
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no user in such id!'
            ];
        }

        $user->delete();

        //check success status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Delete data successfully done!'
        ];
    }
}
