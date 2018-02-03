<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Language;
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
        dd($countries);
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

        /******************************************** recode ************************/

        // choose one language to be the default one, let's make EN is the default
        // store master country
        // store the country in en
        $en_id = Language::where('lang_code', 'en')->first()->id;

        // instantiate App\Model\Country - master
        $country = new Country;

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

        /*********************************************************************************/

        return [
            'status' => true,
            'data' => [
                'country' => $country
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
        if (!$country) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no country with this id!'
            ];
        }


        $country->country_code = $request->country_code;
        if ($country->save()) {

            /*** new ***/

            $country_en = $country->translate('en');
            $country_en->country = $request->country_name_en;

            if (!$country_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            // do the same thing for AR
            if ($request->country_name_ar) {
                // code..
                $country_ar = $country->translate('ar');
                $country_ar->country = $request->country_name_ar;

                if (!$country_en->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }

            /***********/

            return [
                'status' => true,
                'data' => [
                    'country' => $country
                ],
                'msg' => 'data inserted successfully done',
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

        //delete country
        $country->details()->delete();
        $country->delete();
        return [
            'status' => false,
            'data' => null,
            'msg' => 'data is deleted successfully!'
        ];
    }

}
