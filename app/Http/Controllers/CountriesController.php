<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CountryTranslation;
use Illuminate\Http\Request;

/**
 * Class CountriesController
 * @package App\Http\Controllers
 */
class CountriesController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getCountry($id){
        // search for country
        $country=Country::where('id',$id)->get();
        dd($country);

        // if no country, return false status
        if(!$country){
            return[
                'status' => false,
                'data' => null,
                'msg' => 'There is no country with this id!'
            ];
        }
        // get country details
        $country_translated=$country->translate();
        $country->country_translated=$country_translated;

        return[
            'status' => true,
            'data' => [
                'country' => $country,
            ],
            'msg' => 'successfully done!'
        ];
    }


    /**
     * @return array
     */
    public function getAllCountry(){
        //get All Countries
        $countries= Country::all();
        dd($countries);
        //check if no countries
        if(count($countries) == 0){
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no countries exist in DB'
            ];
        }

        //get countries Details
        $country_translated=$countries->translate();

        $countries->country_translated=$country_translated;

        return [
            'status' => true,
            'data' => [
                'countries' => $countries,
            ],
            'msg' => 'Display All Countries'
        ];
    }


    /**
     * @param Request $request
     * @return array
     */
    public function createNewCountry(Request $request)
    {
        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_id' => 'required',
            'lang_id' => 'required',
            'country' => 'required',
        ];

        $validation = validator($request->all(), $validation_countries);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }
        $country = new Country();

        //get countries details

        $lang_id=$country->translate()->get('id');

        $country->country_code=$request->country_code;
        $country->country_id=$request->country_id;
        $country->lang_id=$lang_id;
        $country->country=$request->country;

        if ($country->save()) {

            return [
                'status' => true,
                'data' => [
                    'country' => $country
                ],
                'msg' => 'data inserted successfully done',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'msg' => 'Fail!',
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateCountry(Request $request, $id)
    {
        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_id' => 'required',
            'lang_id' => 'required',
            'country' => 'required',
        ];

        $validation = validator($request->all(), $validation_countries);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        $country = Country::find($id);
        if (!$country) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no country with this id!'
            ];
        }


        $country->country_code = $request->country_code;
        if ($country->save()) {
            $lang_id=$country->translate()->get('id');
            $country_id = $country->countryTrans()->get('id');
            $country->country_id=$country_id;
            $country->lang_id=$lang_id;
            $country->country = $request->country;
            return [
                'status' => true,
                'data' => [
                    'country' => $country
                ],
                'msg' => 'data inserted successfully done',
            ];
        }

        return [
            'status' => false,
            'data' => null,
            'msg' => 'Fail!'
        ];
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteCountry($id){
        //search  for country
        $country=Country::find($id);

        $country_trans=CountryTranslation::where('country_id',$id)->delete();
        //if no country
        if(!$country){
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no Country with this id!'
            ];
        }

        //delete country
        $country->delete();
        return [
            'status' => false,
            'data' => null,
            'msg' => 'data is deleted successfully!'
        ];
    }

}
