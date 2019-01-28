<?php
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('infoUser')) {
    function infoUser($id)
    {
        return DB::table('users')->where('id',$id)->first();
    }
}
if (!function_exists('getSpesialis')) {
    function getSpesialis($name)
    {
        $spesialis = DB::table('teraphis')->where('nama',$name)->first()->spesialis;
        $spesialis = json_decode($spesialis,true);
        $result = null;

        foreach ($spesialis as $key => $data) {
          $result .= infoProduct($data['product_id'])->name.', ';
        }
        return $result;
    }
}
if(!function_exists('getRole')){
    function getRole(){
      return Auth::user()->role;
    }
}


if (!function_exists('randomAvatarName')) {
    function randomAvatarName($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
}
