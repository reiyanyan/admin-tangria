<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Teraphi;
use App\job;
use App\Booking;
use App\Product;

class teraphisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['history', 'store']]);
    }

    public function index(){
      $teraphis = Teraphi::orderBy('id')->get();
      $t = null;
      return view('teraphisPage')->with('teraphis',$teraphis);
    }

    public function baru(){
      $products = Product::all();
      return view('teraphisNew')->with('products', $products);
    }

    public function info(Request $request){
      $teraphis = Teraphi::find($request->id);
      $products = Product::all();
      return view('teraphisInfo')->with(compact('teraphis', 'products'));
    }

    public function update(Request $request){
      $teraphis = Teraphi::where('id',$request->id)->first();
      if($teraphis->count()<=0){
          $teraphis = new Teraphi;
      }

      foreach($request->spesialis as $key){
        $result = array(
          'product_id' => DB::table('products')->where('name', $key)->first()->id,
          'value' => true
        );
        $var[] = $result ;
      }
      $teraphis->nama = $request->name;
      $teraphis->libur = $request->libur;
      $teraphis->spesialis = json_encode($var);
      $teraphis->save();

      return redirect()->back();
    }

    public function save(Request $request){
      $teraphis = Teraphi::where('id',$request->id)->get();
      if($teraphis->count()<=0){
          $teraphis = new Teraphi;
      }


      foreach($request->spesialis as $key){
        $result = array(
          'product_id' => DB::table('products')->where('name', $key)->first()->id,
          'value' => true
        );
        $var[] = $result ;
      }
      $teraphis->nama = $request->nama;
      $teraphis->libur = $request->libur;
      $teraphis->spesialis = json_encode($var);
      $teraphis->save();

      return redirect()->back();

      // return response()->json($var,200);
    }
}
