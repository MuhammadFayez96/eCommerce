<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $countries = Country::all();

        // append translated country to all countries
        foreach ($countries as $country) {

            // get country details
            $country_translated = $country->translate();

            // add the translated country as a key => value to main country object
            // key is country_translated and the value id $country_details
            $country->country_translated = $country_translated;

            $city=City::where('country_id',$country->id)->first();

            $city_translate=$city->translate();

            $country->city_translate=$city_translate;
        }

        return view('admin.pages.addresses.index', compact('countries'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewAddress()
    {
        return view('admin.pages.addresses.add-address');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewAddress(Request $request)
    {
        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_name_en' => 'required',
            'city_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_countries);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master country
        // store the country in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        $country = Country::forceCreate([
            'country_code' => $request->country_code,
        ]);

//        dd($country);
        // check saving success
        if (!$country) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $country_en = $country->countyTrans()->create([
            'country' => $request->country_name_en,
            'lang_id' => $en_id
        ]);

        // check saving status
        if (!$country_en) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong while saving EN country, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->country_name_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $country_ar = $country->countyTrans()->create([
                'country' => $request->country_name_ar,
                'lang_id' => $ar_id
            ]);

            // check saving status
            if (!$country_ar) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving AR country, please try again!'
                ];
            }
        }

        // check if country save
        if ($country) {

            $country_id = $country->id;
            $country = Country::find($country_id);

            // check if no country
            if (!$country) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'There is no country with such id!'
                ];
            }

            // save master city
            $city = City::forceCreate([
                'country_id' => $country_id,
            ]);


            $city_en = null;
            if ($request->city_name_en) {

                $city_en = $city->cityTrans()->create([
                    'city' => $request->city_name_en,
                    'lang_id' => $en_id
                ]);
            }

            // check saving status
            if (!$city_en) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while saving EN, please try again!'
                ];
            }

            // store ar version
            // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
            $city_ar = null;
            if ($request->city_name_ar) {

                $ar_id = Language::where('lang_code', 'ar')->first()->id;

                $city_ar = $city->cityTrans()->create([
                    'name' => $request->city_name_ar,
                    'lang_id' => $ar_id
                ]);

                // check saving status
                if (!$city_ar) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while saving AR, please try again!'
                    ];
                }
            }

            // check success status
            return [
                'status' => 'success',
                'title' => 'successfully',
                'text' => 'Data inserted successfully done',
            ];
        }

        //check save status
        return [
            'status' => 'error',
            'title' => 'Error',
            'msg' => 'something went wrong, please try again!'
        ];
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateAddress($id)
    {
        //get country by id
        $country = Country::find($id);
        //get country details
        $country_details = $country->translate();
        //get country id
        $country_id = $country->id;
        //get city where country_id = $country_id
        $city = City::where('country_id', $country_id)->first();
        //get city_details
        $city_details = $city->translate();

        return view('admin.pages.addresses.edit-address', compact('country', 'country_details', 'city_details'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateAddress($id, Request $request)
    {
        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_name_en' => 'required',
            'city_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_countries);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }

        //find country by id
        $country = Country::find($id);

        //check if no country
        if (!$country) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no country with this id!'
            ];
        }


        $country->country_code = $request->country_code;

        //c heck save success status
        if ($country->save()) {

            $country_en = $country->translate(1);
            $country_en->country = $request->country_name_en;

            // check saving success
            if (!$country_en->save()) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while updating EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->country_name_ar) {

                $country_ar = $country->translate(2);
                $country_ar->country = $request->country_name_ar;

                if (!$country_ar->save()) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            $country_id = $country->id;
            $city = City::where('country_id', $country_id)->first();

            //check if no city
            if (!$city) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'There is no city with this id!'
                ];
            }

            //c heck save success status
            if ($city->save()) {

                $city_en = $city->translate(1);
                $city_en->city = $request->city_name_en;

                // check saving success
                if (!$city_en->save()) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while updating EN, please try again!'
                    ];
                }

                // do the same thing for AR
                if ($request->city_name_ar) {

                    $city_ar = $city->translate(2);
                    $city_ar->city = $request->city_name_ar;

                    if (!$city_ar->save()) {
                        return [
                            'status' => 'error',
                            'title' => 'Error',
                            'text' => 'something went wrong while updating AR, please try again!'
                        ];
                    }
                }

                // check saving success
                return [
                    'status' => 'success',
                    'title', 'success',
                    'text' => 'Data updated successfully done',
                ];
            }
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteAddress($id)
    {
        //find country by id
        $country = Country::find($id);

        // check if no city
        if (!$country) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no city!'
            ];
        }

        $city = City::where('country_id', $id)->first();

        // delete data from cityTrans
        $city->cityTrans()->delete();

        //delete data from city
        $country->city()->delete();

        //delete country
        $country->countyTrans()->delete();

        //delete data from country
        $country->delete();

        //check save successfully
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data deleted successfully done!!'
        ];
    }

}
