<?php

namespace App\Http\Controllers\API;

use App\Models\Bought;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BoughtsController extends Controller
{
    //

    public function getBought($id)
    {
        // find bought by id
        $bought= Bought::find($id);

        // ccheck if no bought
        if(!$bought){
            return[
                'status'=>false,
                'data'=>null,
                'msg'=>'Ther is no bought with this id!'
            ];
        }

        $bought_details=$bought->boughtDetails();
        $bought->bought_details=$bought_details;

        return[
            'status'=>true,
            'data'=>[
                'bought' =>$bought,
                'boughtDetails'=>$bought->boughtDetails()->getResults()
            ],
            'msg'=>'Data Display successfully done!'
        ];
    }

    public function getAllBoughts()
    {

        $boughts= Bought::all();

        if(count($boughts) == 0){
            return [
                'status' => false,
                'data' => null,
                'msg' => 'There are no boughts exist in DB'
            ];
        }

        foreach ($boughts as $bought) {
            $bought_details = $bought->boughtDetails();

            $bought->bought_details = $bought_details;
        }

        //check success status
            return [
                'status' => true,
                'data' => [
                    'boughts' => $boughts,
                ],
                'msg' => 'Display All Countries'
            ];




    }

}
