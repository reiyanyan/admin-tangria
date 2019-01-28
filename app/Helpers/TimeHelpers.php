<?php
use Illuminate\Support\Facades\DB;
use App\time;
if (!function_exists('infoTime')) {
    function infoTime($id)
    {
        return DB::table('times')->where('id',$id)->first();
    }
}
