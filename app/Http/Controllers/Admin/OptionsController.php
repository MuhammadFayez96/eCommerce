<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Option;
use App\Models\OptionValues;
use App\Models\OptionValuesTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OptionsController
 * @package App\Http\Controllers\Admin
 */
class OptionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        //get all option in db
        $options = Option::all();

        // append translated option to all options
        foreach ($options as $option) {

            // get option details
            $option_translated = $option->translate();

            // add the translated option as a key => value to main option object
            // key is option_translated and the value id $option_translated
            $option->option_translated = $option_translated;

            //find optionValue by option_id
            $optionValue = OptionValues::find($option->id);

            //get details for optionValue
            $option_value = $optionValue->translate();

            // add the translated option as a key => value to main option object
            // key is option_value_translated and the value id $option_value
            $option->option_value_translated = $option_value;
        }

        return view('admin.pages.options.index', compact('options'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateNewOption()
    {
        return view('admin.pages.options.add-option');
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
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
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong, please try again!'
            ];
        }

        $option_en = null;
        if ($request->option_name_en) {
            // store en version
            $option_en = $option->optionTrans()->create([
                'option' => $request->option_name_en,
                'lang_id' => $en_id,
            ]);
        }

        // check saving status
        if (!$option_en) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'something went wrong while saving EN, please try again!'
            ];
        }


        if ($option->save()) {

            //get option id
            $option_id = $option->id;

            //find options by id
            $Option = Option::find($option_id);

            //check if no Option
            if (!$Option) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'There is no option with such id!'
                ];
            }

            //store option id in database
            $optionValues = OptionValues::forceCreate([
                'option_id' => $option_id,
            ]);


            // check saving success
            if (!$optionValues->save()) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong, please try again!'
                ];
            }

            //define $optionValues_en is null
            $optionValues_en = null;

            //store multi value in db
            foreach ($request->option_value_en as $key => $v) {
                // store en version
                $optionValues_en = $optionValues->optionValuesTrans()->create([
                    'value' => $request->option_value_en[$key],
                    'lang_id' => $en_id,
                ]);
            }

            // check saving status
            if (!$optionValues_en) {
                return [
                    'status' => 'Error',
                    'title' => 'error',
                    'text' => 'something went wrong while saving EN, please try again!'
                ];
            }

            $option_ar = null;
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
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while saving AR, please try again!'
                    ];
                }
            }

            $optionValues_ar = null;
            if ($request->option_value_ar) {

                //get id if lang code from language model is ar
                $ar_id = Language::where('lang_code', 'ar')->first()->id;

                //store multi value in db
                foreach ($request->option_value_ar as $key => $v) {
                    // store en version
                    $optionValues_ar = $optionValues->optionValuesTrans()->create([
                        'value' => $request->option_value_ar[$key],
                        'lang_id' => $ar_id,
                    ]);
                }

                // check save status
                if (!$optionValues_ar) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while saving AR, please try again!'
                    ];
                }
            }

            // check saving success
            return [
                'status' => 'success',
                'title' => 'success',
                'text' => 'Data Inserted Successfully Done!',
            ];
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateOption($id)
    {
        //find option by id
        $option = Option::find($id);

        //get option details
        $option_translated = $option->translate();

        // add the translated option as a key => value to main option object
        // key is option_translated and the value id $option_translated
        $option->option_translated = $option_translated;

        //get option value details
        $optionValue = OptionValues::where('option_id', $id)->first();

        //get option value translation details
        $optionValues = OptionValuesTranslation::where('option_value_id', $optionValue->id)->get();

        return view('admin.pages.options.edit-option', compact('option', 'optionValues'));
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
                'status' => 'error',
                'title' => $validation->getMessageBag(),
                'text' => 'validation error'
            ];
        }
        //search option by id
        $option = Option::find($id);

        //check if no option
        if (!$option) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no option with this id!'
            ];
        }

        //check save success
        if ($option->save()) {

            //check en lang
            $option_en = $option->translate(1);

            //store option_name_en in option
            $option_en->option = $request->option_name_en;

            // check save status
            if (!$option_en->save()) {
                return [
                    'status' => 'error',
                    'title' => 'Error',
                    'text' => 'something went wrong while updating EN, please try again!'
                ];
            }
/////////////////////////////////////////////////////////////////////
//            $values = $request->option_value_en;
//            for ($i = 0; $i < count($values); $i++) {
//                $optionValue->optionValuesTrans()->update(['value' => $values[$i]]);
//            }

/////////////////////////////////////////////////////////////////////
            //define $optionValues_en is null
            $optionValues_en = null;

            $en_id = Language::where('lang_code', 'en')->first()->id;

            $optionValue = OptionValues::find($option->id);

            //store multi value in db
            foreach ($request->option_value_en as $key => $v) {
                // store en version
                $optionValues_en = $optionValue->optionValuesTrans()->update([
                    'value' => $request->option_value_en[$key],
                    'lang_id' => $en_id,
                ]);
            }

////////////////////////////////////////////////////////////////////

            if ($request->option_name_ar && $request->option_value_ar) {

                //check ar lang for option
                $option_ar = $option->translate(2);

                //store option_name_ar in option
                $option_ar->option = $request->option_name_ar;

                // check save status
                if (!$option_ar->save()) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while updating AR, please try again!'
                    ];
                }

                //check ar lang for
                $optionValue_ar = $optionValue->translate(2);

                $optionValue_ar->value = $request->option_value_ar;

                // check save status
                if (!$optionValue_ar->save()) {
                    return [
                        'status' => 'error',
                        'title' => 'Error',
                        'text' => 'something went wrong while updating AR, please try again!'
                    ];
                }
            }


            // check save success
            return [
                'status' => 'success',
                'title' => 'success',
                'text' => 'Data updated successfully done',
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

        //find option Value by option_id
        $optionValue = OptionValues::where('option_id', $id)->first();

        // check if no option
        if (!$option) {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => 'There is no option with this id!!'
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
            'status' => 'success',
            'title' => 'success',
            'text' => 'Data Deleted Successfully!'
        ];
    }
}
