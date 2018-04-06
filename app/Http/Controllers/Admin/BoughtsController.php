<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BoughtsController extends Controller
{
    public function getIndex()
    {
        return view('admin.pages.boughts.index');
    }

    public function getCreateNewBought()
    {
        $roles=Role::all();
        $products=ProductTranslation::all();

        return view('admin.pages.boughts.add-bought',compact('roles','products'));
    }

    public function createNewBought(Request $request)
    {
        $role_id=$request->role_id;
        $user_id=User::where('role_id',$role_id)->first()->id;
        $product_id=$request->product_id;
    }

    public function getUpdateBought()
    {
        return view('admin.pages.boughts.edit-bought');
    }
}
