<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Storage;
use App\price;
use App\Booking;
use App\Teraphi;

class productController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('category',$request->category)->get();
        foreach ($products as $product) {
            $variable['id'] = $product->id;
            $variable['name'] = $product->name;
            $variable['image'] = "img/product/".$product->image;
            $variable['category'] = $product->category;
            $variable['description'] = $product->description;
            $variable['note'] = $product->note;
            $variable['price'] = infoPrice($product->id);
            $variable['available'] = $product->available;
            $result[] = $variable;
        }
        return response() -> json (
            //  'result_booking_history' => $booking
             $result
         , 200);
    }
    public function save(Request $request)
    {
        $product = Product::where('id',$request->id)->get();
        if($product->count()<=0){
            $product = new Product;
        }
        $product->name = $request->name;
        $product->category = $request->cat;
        $product->description = $request->description;
        $product->note = $request->note;

        $file       = $request->file('image');
        $fileName   = $product->name.sha1(time()).".".$file->getClientOriginalExtension();
        $request->file('image')->move("img/product", $fileName);
        $product->image = $fileName;

        $price = new price;
        $product->save();
        $price->product_id = $product->id;
        $price->save();
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $product = Product::where('id',$request->id)->first();
        if($product->count()<=0){
            $product = new Product;
        }
        $product->name = $request->name;
        $product->category = $request->cat;
        $product->available = $request->available;
        $product->description = $request->description;
        $product->note = $request->note;
        if(!empty($request->file('image'))){
            $file       = $request->file('image');
            $fileName   = $product->name.sha1(time()).".".$file->getClientOriginalExtension();
            $request->file('image')->move("img/product", $fileName);

            $product->image = $fileName;
        }else if(!empty($request->image)){
            $product->image = $request->image;
        }
        $price = new price;
        $product->save();
        return redirect()->back();
    }
    public function home()
    {
        $product = Product::get();
        return view('productHome')->with('products',$product);
    }
    public function productInfo(Request $request){
        $product = Product::find($request->id);
        return view('productInfo')->with('product',$product);
    }
    public function new(){
        return view('productNew');
    }
    public function deleteProduct(Request $request){
        Product::find($request->id)->delete();
        price::where('product_id', $request->id)->delete();
        Booking::where('order', $request->id)->delete();

        $spesialis = Teraphi::where('spesialis','LIKE','%{"product_id":'.$request->id.',"value":true}%')->get();
        $data =  json_decode($spesialis);
        foreach ($data as $key) {
            $teraphis = Teraphi::where('id',$key->id)->first();
            $temp = $key->spesialis;
            $temp = str_replace('{"product_id":'.$request->id.',"value":true},',"",$temp);
            $temp = str_replace(',{"product_id":'.$request->id.',"value":true}',"",$temp);
            $temp = str_replace(',{"product_id":'.$request->id.',"value":true},',"",$temp);
            $temp = str_replace('{"product_id":'.$request->id.',"value":true}',"",$temp);
            $teraphis->spesialis = $temp;
            $teraphis->save(); 
        }
        return redirect()->route('productPage');
    }
}
