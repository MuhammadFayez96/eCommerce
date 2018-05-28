<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Option;
use App\Models\OptionValues;
use App\Models\OptionValuesTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\OptionsControllerApi;

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
        $options_api = new OptionsControllerApi();

        $getIndex_api = $options_api->getIndex();

        if($getIndex_api['status'] == false)
        {
            return [
                'staus' => 'error',
                'title' => 'Error',
                'text' => $getIndex_api['msg']
            ];
        }

        return view('admin.pages.options.index', $getIndex_api['data']);
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
        // get object for OptionsControllerApi
        $options_api = new OptionsControllerApi();

        // call afunction getCreateNewOption from Api
        $newOption_api = $options_api->createNewOption($request);

        // check if ststua is false
        if($newOption_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $newOption_api['msg']
            ];
        }

        // check if status is true
        return [
            'status' => 'success',
            'title' => 'Success',
            'text' => $newOption_api['msg']
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateOption($id)
    {
        // get object for OptionsControllerApi
        $options_api = new OptionsControllerApi();

        // call a function getUpdateOption from API
        $getUpdateOption_api = $options_api->getUpdateOption($id);

        // check if status is false
        if($getUpdateOption_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $getUpdateOption_api['msg']
            ];
        }

        return view('admin.pages.options.edit-option', $getUpdateOption_api['data']);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateOption($id, Request $request)
    {
        // get object for OptionsControllerApi
        $options_api = new OptionsControllerApi();

        // call afunction getUpdateOption from API
        $updateOption_api = $options_api->updateOption($id, $request);

        // check if status is false
        if($updateOption_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $updateOption_api['msg']
            ];
        }

        // check save success
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $updateOption_api['msg'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteOption($id)
    {
        // get object for OptionsControllerApi
        $options_api = new OptionsControllerApi();

        // call afunction deleteOption from API
        $deleteOption_api = $options_api->deleteOption($id);

        //  check if status is false
        if($deleteOption_api['status'] == false)
        {
            return [
                'status' => 'error',
                'title' => 'Error',
                'text' => $deleteOption_api['msg']
            ];
        }

        //check successfully deleted data
        return [
            'status' => 'success',
            'title' => 'success',
            'text' => $deleteOption_api['msg']
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteOptionValue($id)
    {
      // get object for OptionsControllerApi
      $options_api = new OptionsControllerApi();

      // call afunction deleteOptionValue from API
      $deleteOptionValue_api = $options_api->deleteOptionValue($id);

      // check if status is false
      if($deleteOptionValue_api['status'] == false)
      {
        return [
            'status' => 'error',
            'title' => 'Error',
            'text' => $deleteOptionValue_api['msg']
        ];
      }

      //check successfully deleted data
      return [
          'status' => 'success',
          'title' => 'success',
          'text' => $deleteOptionValue_api['msg']
      ];
    }
}
