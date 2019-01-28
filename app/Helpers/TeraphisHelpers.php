<?php
use Illuminate\Support\Facades\DB;
use App\price;
if (!function_exists('infoTeraphis')) {
    function infoTeraphis($pId)
    {
        return DB::table('teraphis')->where('spesialis','LIKE','%"product_id":'.$pId.',"value":true%')->first();
    }
}

if (!function_exists('getTeraphisValue')) {
    function getTeraphisValue($nama,$pId)
    {
        $data =  DB::table('teraphis')->where('nama',$nama)->where('spesialis','LIKE','%"product_id":'.$pId.',"value":true%')->pluck('spesialis');
        $data = json_decode($data,true);
        return $data;
    }
}
