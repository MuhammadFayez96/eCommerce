<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;

/**
 * Class CountriesController
 * @package App\Http\Controllers
 */
class AddressesController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getCountry($id)
    {
        // search for country
        $country = Country::find($id);

        // if no country, return false status
        if (!$country) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no country with this id!'
            ];
        }
        // get country details
        $country_translated = $country->translate();
        $country->country_translated = $country_translated;

        return [
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
    public function getAllCountries()
    {
        //get All Countries
        $countries = Country::all();

        //check if no countries
        if (count($countries) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no countries exist in DB'
            ];
        }

        // append translated country to all countries
        foreach ($countries as $country) {

            // get country details
            $country_translated = $country->translate();

            // add the translated country as a key => value to main country object
            // key is country_translated and the value id $country_details
            $country->country_translated = $country_translated;
        }

        return [
            'status' => true,
            'data' => [
                'countries' => $countries,
            ],
            'msg' => 'Display All Countries'
        ];
    }


    /**
     * create new country
     *
     * @param Request $request
     * @return array
     */
    public function createNewCountry(Request $request)
    {
        // validation countries
        $validation_countries = [
            'country_code' => 'required',
            'country_name_en' => 'required',
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

        // choose one language to be the default one, let's make EN is the default
        // store master country
        // store the country in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Country - master
        $country = new Country;

        $country->country_code = $request->country_code;

        // check saving success
        if (!$country->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
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
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
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
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        // check success status
        return [
            'status' => true,
            'data' => [
                'country' => $country,
                'countryTrans' => $country->countyTrans()->getResults()
            ],
            'msg' => 'data inserted successfully done',
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
            'country_name_en' => 'required',
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

        //check if no country
        if (!$country) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no country with this id!'
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
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->country_name_ar) {

                $country_ar = $country->translate(2);
                $country_ar->country = $request->country_name_ar;

                if (!$country_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            // check saving success
            return [
                'status' => true,
                'data' => [
                    'country' => $country
                ],
                'msg' => 'data updated successfully done',
            ];
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteCountry($id)
    {
        //search  for country
        $country = Country::find($id);

        //if no country
        if (!$country) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no Country with this id!'
            ];
        }

        $city = City::where('country_id', $id)->first();

        //delete country
        $country->countyTrans()->delete();

        //delete data from city
        $country->city()->delete();

        // delete data from cityTrans
        $city->cityTrans()->delete();

        //delete data from country
        $country->delete();

        //check success status
        return [
            'status' => True,
            'data' => null,
            'msg' => 'data is deleted successfully!'
        ];
    }


    // .... cities methods.....//


    public function getCity($id)
    {
        //find city by id
        $city = City::find($id);

        // check if no city
        if (!$city) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no city with this id!'
            ];
        }

        $city_translated = $city->translate();
        $city->city_translated = $city_translated;

        //check success status
        return [
            'status' => true,
            'data' => [
                'city' => $city
            ],
            'msg' => 'Display city successfully done!'
        ];
    }

    public function getAllCities()
    {
        //find all cities from DB
        $cities = City::all();

        // check if no cities in DB
        if (count($cities) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no city!'
            ];
        }

        foreach ($cities as $city) {
            // get cities details
            $city_translated = $city->translate();

            // add the translated city as a key => value to main country object
            // key is city_translated and the value id $city_details
            $city->city_translated = $city_translated;
        }

        // check success status
        return [
            'status' => false,
            'data' => [
                'cities' => $cities
            ],
            'msg' => 'Display all Cities successfully done!'
        ];
    }

    public function createNewCity(Request $request)
    {
        // validation cities
        $validation_cities = [
            'city_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_cities);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master city
        // store the city in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\City - master
        $city = new City;

        $country_id = Country::first()->id;
        $city->country_id = $country_id;

        // check saving success
        if (!$city->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $city_en = $city->cityTrans()->create([
            'name' => $request->city_name_en,
            'lang_id' => $en_id
        ]);

        // check saving status
        if (!$city_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
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
            'status' => true,
            'data' => [
                'city' => $city,
                'cityTrans' => $city->cityTrans()->getResults()
            ],
            'msg' => 'data inserted successfully done',
        ];
    }

    public function updateCity($id, Request $request)
    {
        // validation cities
        $validation_cities = [
            'city_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_cities);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        $city = City::find($id);

        //check if no city
        if (!$city) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no city with this id!'
            ];
        }

        //c heck save success status
        if ($city->save()) {

            $city_en = $city->translate(1);
            $city_en->name = $request->city_name_en;

            // check saving success
            if (!$city_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->city_name_ar) {

                $city_ar = $city->translate(2);
                $city_ar->city = $request->city_name_ar;

                if (!$city_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            // check saving success
            return [
                'status' => true,
                'data' => [
                    'city' => $city
                ],
                'msg' => 'data updated successfully done',
            ];
        }


    }

    public function deleteCity($id)
    {
        //find city by id
        $city = City::find($id);

        // check if no city
        if (!$city) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no city!'
            ];
        }

        // delete data from cityTrans
        $city->cityTrans()->delete();

        //delete data from city
        $city->delete();

        return [
            'status' => true,
            'data' => null,
            'msg' => 'Data deleted successfully done!!'
        ];
    }
}
