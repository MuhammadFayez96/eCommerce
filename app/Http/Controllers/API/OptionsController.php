<?php

namespace App\Http\Controllers\API;

use App\Models\Language;
use App\Models\Option;
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
     * @param Request $request
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


        $option_translated = $option->translate();
        $option->option_translated = $option_translated;

        //check success display data
        return [
            'status' => true,
            'data' => [
                'option' => $option,
            ],
            'msg' => 'Display option successfully done!!'
        ];
    }

    /**
     * @param Request $request
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

        //check successfully display all data
        return [
            'status' => true,
            'data' => [
                'countries' => $options,
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

        // check saving success
        if (!$option->save()) {
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

        // check saving status
        if (!$option_en) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'something went wrong while saving EN, please try again!'
            ];
        }

        // store ar version
        // because it is not required, we check if there is ar in request, then save it, else {no problem, not required}
        if ($request->option_name_ar) {

            $ar_id = Language::where('lang_code', 'ar')->first()->id;

            $option_ar = $option->optionTrans()->create([
                'option' => $request->option_name_ar,
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
        }

        // check saving success
        return [
            'status' => true,
            'data' => [
                'option' => $option,
                'optionTrans' => $option->optionTrans()->getResults()
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

            if ($request->option_name_ar) {
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
            }


            // check save success
            return [
                'status' => true,
                'data' => [
                    'option' => $option
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

        // check if no option
        if (!$option) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There is no option with this id!!'
            ];
        }

        //delete data from optionTrans
        $option->optionTrans()->delete();

        //delete data from optionValues
        $option->optionValues()->delete();

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
