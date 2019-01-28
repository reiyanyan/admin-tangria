<?php
use Illuminate\Support\Facades\DB;
use App\price;
if (!function_exists('infoPrice')) {
    function infoPrice($product_id)
    {
        return DB::table('prices')->where('product_id',$product_id)->first();
    }
}

