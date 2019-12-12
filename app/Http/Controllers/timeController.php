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
        if(!empty($request->ordername)){
                switch($request->ordername){
			case 'Tangria Signature Massage (Tradisional Treatment Package)' :
                        case 'Tangria Signature Massage':
                        case 'Tradisional Treatment Package':
                        case 'Traditional Treatment Package':

                                $timeCheck = $date->setTime(11, 0, 0);
                                for($s=0;$s<=1;$s++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(4)->addMinute(30);
                                }
                                break;
                        case 'Tangria Essence Massage (Javanese Treatment Package)' :
                        case 'Tangria Essence Massage':
                        case 'Javanese Treatment Package':
			        for($s=0;$s<=2;$s++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(3)->addMinute(30);
                                }
                                break;
                        case 'Rejuvenate Massage (Javanese Massage)' :
                        case 'Rejuvenate Massage':
                        case 'Javanese Massage':
                        case 'Relaxing Massage (Swedish Massage)' :
                        case 'Relaxing Massage':
                        case 'Swedish Massage' :
                        case 'Sweedish Massage' :
                                for($i = 0; $i <= 4; $i++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(2);
                                }
                        break;
                        case 'Tangria Hot Stones' :
                        case 'Tangria Stamps' :
                        case 'Fresh Face (Refreshing Facial)' :
                        case 'Fresh Face' :
                        case 'Refreshing Facial' :
                                for($i = 0; $i <= 3; $i++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(2)->addMinute(30);
                                }
                        break;
                        case 'Foot Forward (Reflekxologi)' :
                        case 'Foot Forward':
                        case 'Reflekxology':
                        case 'Reflexology':
                                for($i = 0; $i <= 9; $i++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(1);
                                }
                        break;
                        case 'Hair Care (Hair Spa)' :
                        case 'Hair Care':
                        case 'Hair Spa': 
                        case 'Twinkle Nail & Twinkle Toes (Mani & Pedi)' :
                        case 'Twinkle Nail & Twinkle Toes' :
                        case 'Mani & Pedi' :
                                for($i = 0; $i <= 4; $i++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(2);
                                }
                        break;
                        case 'Total Hand and Foot Spa' :
                                for($i = 0; $i <= 3; $i++){
                                        $status["time"] = $timeCheck->format('H:i:s');
                                        if(DB::table('times')->where('date', $timeCheck->format('Y-m-d H:i:s') )->count() <=0){
                                                $status["available"] = true;
                                        }else{
                                                $status["available"] = false;
                                        }
                                        $time[] = $status;
                                        $timeCheck->addHour(2)->addMinute(30);
                                }
                        break;
                        default:
                                for($i = 0; $i <= 9; $i++){
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
