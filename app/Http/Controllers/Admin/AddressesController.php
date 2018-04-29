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
        $ar_id = Language::where('lang_code', 'ar')->first()->id;


        $country = Country::forceCreate([
            'country_code' => $request->country_code,
        ]);

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

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->country_name_ar) {

            $country_ar = $country->countyTrans()->create([
                'country' => $request->country_name_ar,
                'lang_id' => $ar_id
            ]);
        }

        // check if country save
        if (!$country) {
            //check save status
            return [
                'status' => 'error',
                'title' => 'Error',
                'msg' => 'something went wrong, please try again!'
            ];
        }

        $country_id = $country->id;


        foreach ($request->city_name_en as $key => $city_name_en) {

            if ($city_name_en) {

                // save master city
                $city = City::forceCreate([
                    'country_id' => $country_id,
                ]);

                $city_en = $city->cityTrans()->create([
                    'city' => $city_name_en,
                    'lang_id' => $en_id
                ]);

                if ($request->city_name_ar[$key]) {

                    $city_ar = $city->cityTrans()->create([
                        'city' => $request->city_name_ar[$key],
                        'lang_id' => $ar_id
                    ]);
                }
            }
        }

        // check success status
        return [
            'status' => 'success',
            'title' => 'successfully',
            'text' => 'Data inserted successfully done',
        ];
    }

    /**
    * get add new city template
    */
    public function getAddCitiesTemplate()
    {
        return view('admin.pages.addresses.templates.add-country.add-city')->render();
    }

    /*
    * get add new city template - for edit
    */
    public function getAddCitiesTemplateInEdit()
    {
        return view('admin.pages.addresses.templates.add-country.add-city-in-edit')->render();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateAddress($id)
    {
        //get country by id
        $country = Country::find($id);
        //get country en
        $country->en = $country->translate('en');
        //get country ar
        $country->ar = $country->translate('ar');
        //get country id

        $country->cities;

        foreach ($country->cities as $city) {

            $city->en = $city->translate('en');
            $city->ar = $city->translate('ar');
        }

        return view('admin.pages.addresses.edit-address', compact('country'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateAddress(Request $request)
    {

        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_name_en' => 'required',
            'cities_names_en' => 'required',
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
        $country = Country::find($request->country_id);

        //check if no country
        if (!$country) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no country with this id!'
            ];
        }

        $country->country_code = $request->country_code;

        if ($country->save()) {

            $en_id = Language::where('lang_code', 'en')->first()->id;
            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $country->translate('en')->update([
                'country' => $request->country_name_en
            ]);

            if ($request->country_name_ar) {

                if ($country->translate('ar')) {

                    $country->translate('ar')->update([
                        'country' => $request->country_name_ar
                    ]);

                } else {

                    $country->countyTrans()->create([
                        'country' => $request->country_name_ar,
                        'country_id' => $request->country_id,
                        'lang_id' => $ar_id
                    ]);
                }
            } else {

                $country->translate('ar') ? $country->translate('ar')->delete() : '';
            }


            $cities_name_en = $request->cities_names_en;
            $cities_name_ar = $request->cities_names_ar;

            foreach ($cities_name_en as $key => $city_en) {

                if (!$city_en) continue;

                if (array_key_exists(1, $city_en)) {

                    $city = City::find($city_en[1]);

                    $city->cityTrans()->delete();

                    $city->cityTrans()->create([
                        'city' => $city_en[0],
                        'lang_id' => $en_id,
                        'city_id' => $city->id
                    ]);

                    if (array_key_exists($key, $cities_name_ar)) {

                        $city->cityTrans()->create([
                            'city' => $cities_name_ar[$key][0],
                            'lang_id' => $ar_id,
                            'city_id' => $city->id
                        ]);
                    }

                    continue;
                }

                $city = City::forceCreate([
                    'country_id' => $country->id,
                ]);

                $city->cityTrans()->create([
                    'city' => $city_en[0],
                    'lang_id' => $en_id
                ]);

                if (array_key_exists($key, $cities_name_ar)) {

                    $city->cityTrans()->create([
                        'city' => $cities_name_ar[$key][0],
                        'lang_id' => $ar_id
                    ]);
                }
            }
        }

        // check saving success
        return [
            'status' => 'success',
            'title', 'success',
            'text' => 'Data updated successfully done',
        ];
    }

    /**
    * delete city
    */
    public function deleteCity($id)
    {
        return City::find($id)->delete() ? ['status' => true] : ['status' => false];
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
