<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\price;

class priceController extends Controller
{
    public function index(){
        if(getRole() == 2){
            $prices = price::orderBy('harga')->get();
            return view('price')->with('prices', $prices);
        } else {
            return back();
        }

    }
    public function edit(Request $request){
        if(getRole() == 2){
            $prices = price::find($request->id);
            return view('editPrice')->with('prices', $prices);
        } else {
            return back();
        }

    }
    public function update(Request $request){
        if(getRole() == 2){
            $prices = price::where('id',$request->id)->first();
            if($prices->count()<=0){
                $prices = new price;
            }
            $prices->harga = $request->price;
            $prices->diskon = $request->diskon;
            $prices->save();
            return redirect()->back();
        } else {
            return back();
        }
    }
}
