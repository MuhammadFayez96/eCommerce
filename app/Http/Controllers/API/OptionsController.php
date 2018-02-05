<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Models\Option;
use App\Models\OptionValues;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OptionsController
 * @package App\Http\Controllers\API
 */
class OptionsController extends Controller
{

    /**
     * @param $id
     * @return array
     */
    public function getOption($id)
    {
        //search option by id
        $option = Option::find($id);

        //check if option not found
        if (!$option) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!'
            ];
        }

        $optionValue = OptionValues::where('option_id', $id)->first();

        $option_translated = $option->translate();
        $option->option_translated = $option_translated;

        $optionValue_translated = $optionValue->translate();
        $optionValue->optionValue_translated = $optionValue_translated;

        //check success display data
        return [
            'status' => true,
            'data' => [
                'option' => $option,
                'optionValue' => $optionValue,
            ],
            'msg' => 'Display option and optionValues successfully done!!'
        ];
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        //get all option in db
        $options = Option::all();

        //check if no options
        if (count($options) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!!'
            ];
        }

        // append translated option to all options
        foreach ($options as $option) {

            // get option details
            $option_translated = $option->translate();

            // add the translated option as a key => value to main option object
            // key is option_translated and the value id $option_translated
            $option->option_translated = $option_translated;
        }

        //get all option in db
        $optionValues = OptionValues::all();

        //check if no options
        if (count($optionValues) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!!'
            ];
        }

        // append translated option to all options
        foreach ($optionValues as $optionValue) {

            // get option details
            $optionValue_translated = $optionValue->translate();

            // add the translated option as a key => value to main option object
            // key is option_translated and the value id $option_translated
            $optionValue->optionValue_translated = $optionValue_translated;
        }

        //check successfully display all data
        return [
            'status' => true,
            'data' => [
                'options' => $options,
                'optionValues' => $optionValues,
            ],
            'msg' => 'Display All Options'
        ];
    }


    /**
     * @param Request $request
     * @return array
     */
    public function createNewOption(Request $request)
    {
        // validation options
        $validation_options = [
            'option_name_en' => 'required',
            'option_value_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_options);

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

        // instantiate App\Model\Option - master
        $option = new Option;

        $optionValues = new OptionValues;

        $id = Option::first()->id;
        $optionValues->option_id = $id;

        // check saving success
        if (!$option->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // check saving success
        if (!$optionValues->save()) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong, please try again!'
            ];
        }

        // store en version
        $option_en = $option->optionTrans()->create([
            'option' => $request->option_name_en,
            'lang_id' => $en_id,
        ]);

        // store en version
        $optionValues_en = $optionValues->optionValuesTrans()->create([
            'value' => $request->option_value_en,
            'lang_id' => $en_id,
        ]);

        // check saving status
        if (!$option_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // check saving status
        if (!$optionValues_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->option_name_ar && $request->option_value_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $option_ar = $option->optionTrans()->create([
                'option' => $request->option_name_ar,
                'lang_id' => $ar_id,
            ]);

            $optionValues_ar = $optionValues->optionValuesTrans()->create([
                'Value' => $request->option_value_ar,
                'lang_id' => $ar_id,
            ]);

            // check save status
            if (!$option_ar) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while saving AR, please try again!'
                ];
            }

            // check save status
            if (!$optionValues_ar) {
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
                'option' => $option,
                'optionTrans' => $option->optionTrans()->getResults(),
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
    public function updateOption($id, Request $request)
    {
        // validation options
        $validation_options = [
            'option_name_en' => 'required',
            'option_value_en' => 'required',
        ];

        $validation = validator($request->all(), $validation_options);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }
        //search option by id
        $option = Option::find($id);

        $optionValue = OptionValues::where('option_id', $id)->first();

        //check if no option
        if (!$option) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!'
            ];
        }

        //check save success
        if ($option->save()) {

            $option_en = $option->translate(1);
            $option_en->option = $request->option_name_en;

            // check save status
            if (!$option_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            $optionValue_en = $optionValue->translate(1);
            $optionValue_en->value = $request->option_value_en;

            // check save status
            if (!$optionValue_en->save()) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'something went wrong while updating EN, please try again!'
                ];
            }

            if ($request->option_name_ar && $request->option_value_ar) {
                $option_ar = $option->translate(2);
                $option_ar->option = $request->option_name_ar;

                // check save status
                if (!$option_ar->save()) {
                    return [
                        'status' => false,
                        'data' => null,
                        'msg' => 'something went wrong while updating AR, please try again!'
                    ];
                }

                $optionValue_ar = $optionValue->translate(2);
                $optionValue_ar->value = $request->option_value_ar;

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
                    'option' => $option,
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
    public function deleteOption($id)
    {
        //search option by id
        $option = Option::find($id);
        $optionValue = OptionValues::where('option_id', $id)->first();
//        $option_value_id = OptionValues::where('option_id', $id)->first()->id;

        // check if no option
        if (!$option) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!!'
            ];
        }

        //delete data from optionValuesTrans
        $optionValue->optionValuesTrans()->delete();

        //delete data from productOptionValuesDetails
        $optionValue->productOptionValuesDetails()->delete();

        //delete data from optionValues
        $option->optionValues()->delete();

        //delete data from optionTrans
        $option->optionTrans()->delete();

        //delete data from option
        $option->delete();

        //check successfully deleted data
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Data Deleted Successfully!'
        ];
    }
}
