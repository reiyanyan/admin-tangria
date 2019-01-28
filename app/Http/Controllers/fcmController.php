<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\time;
use App\Classes\Firebase;
use App\Classes\Push;
require('vendor/autoload.php');

class fcmController extends Controller
{

  public function getToken(){
    
    return $token;
  }

  public function send(Request $request){

    $notification = new Notification('Hello World');
    $notification->setBody('My awesome Hello World!');

    // Create the message
    $message = new Message($notification);
    $message->setData([
        'data-1' => 'Lorem ipsum',
        'data-2' => '1234',
        'data-3' => 'true'
    ]);
    $message->setToken($request->token);

    $projectId = 'bookingku-4d882';
    $oauthToken = '';

    $fcm = new Fcm($oauthToken, $projectId);
    $response = $fcm->send()->message($message);
    return response()->json([
      'oke'=>'oke'
    ]);
  }

}
