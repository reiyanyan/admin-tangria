<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\price;

class priceController extends Controller
{
    public function index(){
        $prices = price::orderBy('harga')->get();
        return view('price')->with('prices', $prices);
    }
    public function edit(Request $request){
        $prices = price::find($request->id);
        return view('editPrice')->with('prices', $prices);
    }
    public function update(Request $request){
        $prices = price::where('id',$request->id)->first();
        if($prices->count()<=0){
            $prices = new price;
        }
        $prices->harga = $request->price;
        $prices->diskon = $request->diskon;
        $prices->save();
        return redirect()->back();
    }
}
