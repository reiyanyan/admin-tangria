<?php
use Illuminate\Support\Facades\DB;
use App\Product;
if (!function_exists('infoProduct')) {
    function infoProduct($id)
    {
        return DB::table('products')->where('id',$id)->first();
    }
}

