<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Models\Option;
use App\Models\OptionTranslation;
use App\Models\OptionValues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OptionValueController
 * @package App\Http\Controllers\API
 */
class OptionValueController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getOptionValue($id)
    {
        //search option by id
        $optionValue = OptionValues::find($id);

        //check if option not found
        if (!$optionValue) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no optionValue with this id!'
            ];
        }


        $optionValue_translated = $optionValue->translate();
        $optionValue->optionValue_translated = $optionValue_translated;

        //check success display data
        return [
            'status' => true,
            'data' => [
                'option' => $optionValue,
            ],
            'msg' => 'Display option successfully done!!'
        ];
    }


    /**
     * @return array
     */
    public function getAllOptionsValues()
    {
        //get all optionValue from Model OptionValues
        $optionsValues = OptionValues::all();

        //check if no optionsValues
        if (count($optionsValues) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no optionsValues with this id!!'
            ];
        }

        // append translated option to all options
        foreach ($optionsValues as $optionValue) {

            // get optionValue details
            $optionValue_translated = $optionValue->translate();

            // add the translated option as a key => value to main option object
            // key is optionValue_translated and the value id $optionValue_translated
            $optionValue->optionValue_translated = $optionValue_translated;
        }

        //check successfully display all data
        return [
            'status' => true,
            'data' => [
                'countries' => $optionsValues,
            ],
            'msg' => 'Display All Options Values'
        ];
    }


    public function createNewOptionValue(Request $request)
    {
        // validation options
        $validation_optionValues = [
            'value_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_optionValues);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        // choose one language to be the default one, let's make EN is the default
        // store master option
        // store the option in en
        $en_id = Language::where('lang_code', 'en')->first()->id;
        $id = Option::first()->id;
//        $option_id=OptionTranslation::where('option_id',$id)->first()->id;
//        dd($option_id);
        // instantiate App\Model\Option - master
        $optionValues = new OptionValues;

        $optionValues->option_id = $id;

        // check saving success
        if (!$optionValues->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }


        // store en version
        $optionValue_en = $optionValues->optionValuesTrans()->create([
            'value' => $request->value_name_en,
            'lang_id' => $en_id,
        ]);
        // check saving status
        if (!$optionValue_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->value_name_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $optionValue_ar = $optionValues->optionValuesTrans()->create([
                'value' => $request->value_name_ar,
                'lang_id' => $ar_id,
            ]);


            // check save status
            if (!$optionValue_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }
        }

        // check saving success
        return [
            'status' => true,
            'data' => [
                'optionValues' => $optionValues,
                'optionValuesTrans' => $optionValues->optionValuesTrans()->getResults()
            ],
            'msg' => 'Data inserted successfully done',
        ];
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateOptionValue($id, Request $request)
    {
        // validation optionsValues
        $validation_optionValues = [
            'value_name_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_optionValues);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }
        //search option by id
        $optionValue = OptionValues::find($id);

        //check if no option
        if (!$optionValue) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!'
            ];
        }

        //check save success
        if ($optionValue->save()) {

            $optionValue_en = $optionValue->translate(1);
            $optionValue_en->value = $request->value_name_en;

            // check save status
            if (!$optionValue_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->value_name_ar) {
                $optionValue_ar = $optionValue->translate(2);
                $optionValue_ar->value = $request->value_name_ar;

                // check save status
                if (!$optionValue_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }


            // check save success
            return [
                'status' => true,
                'data' => [
                    'optionValue' => $optionValue,

                ],
                'msg' => 'Data updated successfully done',
            ];
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteOptionValue($id)
    {
        //search optionValues by id
        $optionValue = OptionValues::find($id);

        // check if no optionValues
        if (!$optionValue) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no optionValue with this id!!'
            ];
        }

        //delete data from optionValuesTrans
        $optionValue->optionValuesTrans()->delete();

        //delete data from optionValue
        $optionValue->delete();

        //check successfully deleted data
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Data Deleted Successfully!'
        ];
    }
}
