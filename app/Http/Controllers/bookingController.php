<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Booking;
use App\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Teraphi;
use App\Inbox;
use Carbon\Carbon;

class bookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['history', 'store','searchUser','searchDate']]);
    }
    //
    public function index(){
        $bookings = Booking::orderBy('created_at', 'DESC')->paginate(10);
        return view('book')->with('bookings', $bookings);
    }
    public function searchUser(Request $request){
        setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID');
        $bookings = DB::table('bookings')
                ->select('bookings.id','users.name','bookings.room','bookings.date','bookings.status','products.name AS order')
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->join('products', 'bookings.order', '=', 'products.id')
                ->where('users.name','LIKE', '%'.$request->name.'%')
                ->orWhere('code', $request->name)
                ->get();

        foreach ($bookings as $key => $booking) {
            $booking->date = strftime("%A, %B %d %Y. %H:%M", strtotime($booking->date));
        }

        return $bookings;
    }
    public function searchDate(Request $request){
        setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID');
        $carbon = new \Carbon\Carbon($request->name);
        $carbon = $carbon->format('Y-m-d');
        $bookings = DB::table('bookings')->select('bookings.id','users.name','bookings.room','bookings.date','bookings.status','products.name AS order')->join('users', 'bookings.user_id', '=', 'users.id')->join('products', 'bookings.order', '=', 'products.id')->where('bookings.date','LIKE', '%'.$carbon.'%' )->get();

        foreach ($bookings as $key => $booking) {
            $booking->date = strftime("%A, %B %d %Y. %H:%M", strtotime($booking->date));
        }

        return $bookings;
    }
    public function store(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if($user->role != 0){
            $booking = new Booking;
            $booking->user_id = $request->user_id;
            $booking->order = $request->order;
            $booking->date = $request->date;
            $booking->save();
            return response()->json([
                'success' => 'true'
            ], 200);
        } else {
            return response()->json([
                'success' => 'false'
            ]);
        }

    }
    public function history(Request $request){
        $booking = Booking::where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->get();
        $result = array();
        foreach ($booking as $data) {
            $variable['order'] = DB::table('products')->where('id',$data->order)->first()->name;
            $variable['order_img'] = DB::table('products')->where('id',$data->order)->first()->image;
            $variable['order_desc'] = DB::table('products')->where('id',$data->order)->first()->description;
            // $variable['order'] = infoProduct($data->order)->name;
            // $variable['order_img'] = infoProduct($data->order)['image'];
            // $variable['order_desc'] = infoProduct($data->order)['description'];
            $variable['date'] = $data->date;
            $variable['status'] = $data->status;
            $variable['code'] = $data->code;
            $result[] = $variable;
        }
        return response() -> json ([
            //  'result_booking_history' => $booking
             'result_booking_history' => $result
         ], 200);
    }
    public function infoWeb(Request $request){
        $booking = Booking::find($request->id);
        $pId= $booking->order;
        setlocale(LC_TIME, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID');
        $day = strftime("%A", strtotime($booking->date));
        $teraphis = Teraphi::where('spesialis','LIKE','%"product_id":'.$pId.',"value":true%')->where('libur','!=',$day)->get();
        return view('bookingInfo')->with(compact('teraphis', 'booking'));
    }
    public function bookingCancel(Request $request){
        $title = "Pesanan Dibatalkan";
        $body = $request->pesan;

        $booking = Booking::find($request->id);
        $booking->status = 'cancel';
        $booking->message = $request->pesan;
        $booking->save();


        $inbox = new Inbox;
        $inbox->user_id = $booking->user_id;
        $inbox->title = $title;
        $inbox->content = $body;
        $inbox->save();

$token = array(infoUser($booking->user_id)->fcm_token);

        $this->kirimWoe($token, $title, $body);

        return redirect()->back();
    }
    public function bookingDone(Request $request){
        $teraphis = $request->teraphis;
        $ruangan = $request->room;
        $title = "Pesanan Diterima";
        $body = "Hore! Pesanan kamu telah diterima oleh Teraphis " . $teraphis . " di ruangan " . $ruangan;

        $char="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $random = substr(str_shuffle($char), 0, 4);

        $booking = Booking::find($request->id);
        $booking->status = "diterima";
        $booking->room = $request->room;
        $booking->teraphist = $teraphis;
        $booking->code = date('ymd', strtotime($booking->date)). $random;
        $booking->save();


        $inbox = new Inbox;
        $inbox->user_id = $booking->user_id;
        $inbox->title = $title;
        $inbox->content = $body;
        $inbox->teraphis = $request->teraphis;
        $inbox->save();

$token = array(infoUser($booking->user_id)->fcm_token);

        $this->kirimWoe($token, $title, $body);

        return redirect()->back();
    }

public function kirimWoe($token, $title, $message){

        define( 'API_ACCESS_KEY', 'AAAA-qBl5vM:APA91bFC7xt4sPPm9hiIEoVO2eNWFvK6CmYhbjpAslrmG_9CmQ-cpsS_lWGBHd0soaSdc0Pj4zO6psrJW7UnYlL0ekvqrsj4k6hrzWIJgy4bmLfa3R1kjAjkDMUJ42WXX0LjPj6OBnCw' );

        $msg = array
        (
            "message" 	=> $message,
            "title"		=> $title
        );

        $fields = array
        (
            'registration_ids' 	=> $token,
            'data'			=> $msg
        );

        // echo response()->json($fields);
        // echo json_encode($fields, JSON_PRETTY_PRINT);
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;

        return response()->json( $result );
    }

}
