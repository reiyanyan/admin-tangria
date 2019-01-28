<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Booking;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Inbox;
use App\User;

class dateController extends Controller
{
    public function index(){
        $results = DB::table('times')->paginate(10);
        return view('date')->with('results',$results);
    }
    public function dateSave(Request $request){
        $data = $request->date." ".$request->time;
        DB::table('times')->insert([
            'date' => $data,
            'reason' => $request->description
            ]);

        $datee = Booking::where('date', $data)->get();

        if($datee != NULL){
            foreach($datee as $date){
                DB::table('bookings')->where('date', $date->date)->update([
                    'status' => 'cancel'
                ]);

                $optionBuilder = new OptionsBuilder();

                $title = 'Jam Tidak Tersedia';
                $content = 'Maaf, kami tutup di jam ' . $request->time ;

                $notificationBuilder = new PayloadNotificationBuilder($title);
                $notificationBuilder->setBody($content)->setSound('default');

                $inbox = new Inbox;
                $inbox->user_id = $date->user_id;
                $inbox->title = $title;
                $inbox->content = $content;
                $inbox->save();

                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData(['a_data' => 'my_data']);

                $option = $optionBuilder->build();
                $notification = $notificationBuilder->build();
                $data = $dataBuilder->build();

                $tokens = User::where('id', $date->user_id)->pluck('fcm_token')->toArray();

                $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

                $downstreamResponse->numberSuccess();
                $downstreamResponse->numberFailure();
                $downstreamResponse->numberModification();
            }
        }
        return redirect()->back();
    }
    public function dateDelete(Request $request){
        DB::table('times')->where('id',$request->id)->delete();
        return redirect()->back();
    }
}
