<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\AddressesControllerApi;

/**
 * Class AddressesController
 * @package App\Http\Controllers\Admin
 */
class AddressesController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $address_api = new AddressesControllerApi();

        $getIndex_api = $address_api->getIndex();

        return view('admin.pages.addresses.index', $getIndex_api['data']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewAddress()
    {
        $address_api = new AddressesControllerApi();

        $getCreateNewAddress_api = $address_api->getCreateNewAddress();

        if($getCreateNewAddress_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getCreateNewAddress_api['msg']
            ];
        }

        return view('admin.pages.addresses.add-address');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewAddress(Request $request)
    {

        $address_api = new AddressesControllerApi();

        $createNewAddress_api = $address_api->createNewAddress($request);

        if($createNewAddress_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => ' Error',
                'text' =>$createNewAddress_api['msg']
            ];
        }

        // check success status
        return [
            'status' => 'success',
            'title' => 'successfully',
            'text' => $createNewAddress_api['msg']
        ];
    }

    /**
    * get add new city template
    */
    public function getAddCitiesTemplate()
    {
        $address_api = new AddressesControllerApi();

        $getAddCitiesTemplate_api = $address_api->getAddCitiesTemplate();

        if($getAddCitiesTemplate_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getAddCitiesTemplate_api['msg']
            ];
        }

        return view('admin.pages.addresses.templates.add-country.add-city')->render();
    }

    /*
    * get add new city template - for edit
    */
    public function getAddCitiesTemplateInEdit()
    {
        $address_api = new AddressesControllerApi();

        $getAddCitiesTemplateInEdit_api = $address_api->getAddCitiesTemplateInEdit();

        if($getAddCitiesTemplateInEdit_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getAddCitiesTemplateInEdit_api['msg']
            ];
        }

        return view('admin.pages.addresses.templates.add-country.add-city-in-edit')->render();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateAddress($id)
    {
        $address_api = new AddressesControllerApi();

        $getUpdateAddress_api = $address_api->getUpdateAddress($id);

        if($getUpdateAddress_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateAddress_api['msg']
            ];
        }

        return view('admin.pages.addresses.edit-address', $getUpdateAddress_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateAddress(Request $request)
    {
        $address_api = new AddressesControllerApi();

        $updateAddress_api = $address_api->updateAddress($request);

        if($updateAddress_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateAddress_api['msg']
            ];
        }

        // check saving success
        return [
            'status' => 'success',
            'title', 'success',
            'text' => $updateAddress_api['msg'],
        ];
    }

    /**
    * delete city
    */
    public function deleteCity($id)
    {
        $address_api = new AddressesControllerApi();

        $deleteCity_api = $address_api->deleteCity($id);

        if($deleteCity_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteCity_api['msg']
            ];
        }

        return City::find($id)->delete() ? ['status' => true] : ['status' => false];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteAddress($id)
    {
        $address_api = new AddressesControllerApi();

        $deleteAddress_api = $address_api->deleteAddress($id);

        if($deleteAddress_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteAddress_api['msg']
            ];
        }

        //check save successfully
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $deleteAddress_api['msg']
        ];
    }

}
