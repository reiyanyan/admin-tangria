<?php

use \Carbon\Carbon;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\time;
use App\User;


class timeController extends Controller
{
    //
    public function index(Request $request)
    {
        $date = \Carbon\Carbon::parse($request->date);
        $timeCheck = $date->setTime(10, 0, 0);
        if(!empty($request->ordername) && $request->ordername == 'Javanese Treatment Package' ){
	
               for($s=0;$s<9;$s++){
                        $status["time"] = $timeCheck->format('H:i:s');
                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0 && ( $status["time"] == '10:00:00' || $status["time"] == '14:00:00' || $status["time"] == '17:00:00' )){
                                $status["available"] = true;
                        }else{
                                $status["available"] = false;
                        }
                        $time[] = $status;
                        $timeCheck->addHour(1);
                }


	}
	else if(!empty($request->ordername) && $request->ordername == 'Traditional Treatment Package' ){
	       for($s=0;$s<9;$s++){
                        $status["time"] = $timeCheck->format('H:i:s');
                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0 && ( $status["time"] == '10:00:00' || $status["time"] == '15:00:00')){
                                $status["available"] = true;
                        }else{
                                $status["available"] = false;
                        }
                        $time[] = $status;
                        $timeCheck->addHour(1);
                }
	}
	else{
	        for($s=0;$s<9;$s++){
                	$status["time"] = $timeCheck->format('H:i:s');
                	if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                    		$status["available"] = true;
                	}else{
                    		$status["available"] = false;
                	}
                	$time[] = $status;
                	$timeCheck->addHour(1);
        	}
	}
        return response()->json([
            'result_available_time' => $time,
        ], 200);
    }
    public function busy()
    {
        $db = time::select('date', 'reason')->get();

        return response()->json([
            'time' => $db,
        ], 200);
    }
}
