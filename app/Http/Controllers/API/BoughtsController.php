<?php

namespace App\Http\Controllers\API;

use App\Models\Bought;
use App\Models\BoughtDetails;
use App\Models\Product;
use App\Models\ProductOptionValues;
use App\Models\User;
use DeepCopy\f001\B;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BoughtsController
 * @package App\Http\Controllers\API
 */
class BoughtsController extends Controller
{
    //

    /**
     * @param $id
     * @return array
     */
    public function getBought($id)
    {
        // find bought by id
        $bought = Bought::find($id);

        // ccheck if no bought
        if (!$bought) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'Ther is no bought with this id!'
            ];
        }

        $bought_details = $bought->details()->getResults();

        $bought->bought_details = $bought_details;


        // check save status
        return [
            'status' => true,
            'data' => [
                'bought' => $bought,
            ],
            'msg' => 'Data Display successfully done!'
        ];
    }

    /**
     * @return array
     */
    public function getAllBoughts()
    {

        //display all boughts in db
        $boughts = Bought::all();

        // check if no bought
        if (count($boughts) == 0) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no boughts exist in DB'
            ];
        }


        foreach ($boughts as $bought) {

            $bought_details = $bought->details()->getResults();

            $bought->bought_details = $bought_details;

        }

        //check success status
        return [
            'status' => true,
            'data' => [
                'boughts' => $boughts,
            ],
            'msg' => 'Display All Boughts successfully done!'
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createNewBought(Request $request)
    {
        // validation boughts
        $validation_boughts = [
            'total_amount' => 'required',
            'total_price' => 'required',
            'type' => 'required',
            'paid' => 'required',
            'remain' => 'required',
            'amount' => 'required',
            'cost' => 'required',
            'product_type' => 'required',
        ];

        $validation = validator($request->all(), $validation_boughts);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        $bought = new Bought;

        /*******************************************************/
        $user_id = User::first()->id;

        $bought->user_id = $user_id;
        /*******************************************************/

        $bought->total_amount = $request->total_amount;
        $bought->total_price = $request->total_price;
        $bought->type = $request->type;
        $bought->paid = $request->paid;
        $bought->remain = $request->remain;


        /***********************************************************/
        $product_id = Product::first()->id;

        $product_option_value_id = ProductOptionValues::where('product_id', $product_id)->first()->id;

        $bought_id = Bought::first()->id;
        /***********************************************************/

        // check save status
        if ($bought->save()) {
            $bought_details = $bought->boughtDetails()->forceCreate([
                'bought_id' => $bought_id,
                'amount' => $request->amount,
                'cost' => $request->cost,
                'product_type' => $request->product_type,
                'product_id' => $product_id,
                'product_option_value_id' => $product_option_value_id,
            ]);

            // check if no bought details
            if (!$bought_details) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'There is no bought details!'
                ];
            }

            // check save status
            return [
                'status' => true,
                'data' => [
                    'boughts' => $bought,
                    'boughtDetails' => $bought_details,
                ],
                'msg' => 'Data inserted successfully done',
            ];
        }
    }


    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function updateBought($id, Request $request)
    {
        // validation boughts
        $validation_boughts = [
            'total_amount' => 'required',
            'total_price' => 'required',
            'type' => 'required',
            'paid' => 'required',
            'remain' => 'required',
            'amount' => 'required',
            'cost' => 'required',
            'product_type' => 'required',
        ];

        $validation = validator($request->all(), $validation_boughts);

        // if validation failed, return false response
        if ($validation->fails()) {
            return [
                'status' => false,
                'data' => $validation->getMessageBag(),
                'msg' => 'validation error'
            ];
        }

        //find bought by id
        $bought = Bought::find($id);

        // check if no bought
        if (!$bought) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'there id no bought with this id!'
            ];
        }

        $bought->total_amount = $request->total_amount;
        $bought->total_price = $request->total_price;
        $bought->type = $request->type;
        $bought->paid = $request->paid;
        $bought->remain = $request->remain;

        // check save success
        if ($bought->save()) {
            $bought_details = BoughtDetails::where('bought_id', $id)->first();
            $bought_details->amount = $request->amount;
            $bought_details->cost = $request->cost;
            $bought_details->product_type = $request->product_type;

            // check if no bought details
            if (!$bought_details) {
                return [
                    'status' => false,
                    'data' => null,
                    'msg' => 'there id no bought with this id!'
                ];
            }

            //check save success
            if ($bought_details->save()) {
                return [
                    'status' => true,
                    'data' => [
                        'bought' => $bought,
                        'bought_details' => $bought_details,
                    ],
                    'msg' => 'Data updated successfully done',
                ];
            }
        }
    }


    /**
     * @param $id
     * @return array
     */
    public function deleteBought($id)
    {
        $bought = Bought::find($id);

        if (!$bought) {
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no boughts exist in DB'
            ];
        }

        // delete data from  boughtDetails
        $bought->boughtDetails()->delete();

        // delete data from bought
        $bought->delete();

        //check success status
        return [
            'status' => true,
            'data' => null,
            'msg' => 'Delete data successfully done!'
        ];
    }
}
