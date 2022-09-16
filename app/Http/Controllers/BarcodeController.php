<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class BarcodeController extends Controller
{
    public function showbarcode()
    {
        $products = Product::where('product_status','=','Y')->get();
        return view('barcodes.showbarcode',compact('products'));
    }
    public function generatebarcode(Request $request)
    {
        $barcode = Product::where('id','=', $request->product_id)->first();
        if ($barcode == null)
        {
            return redirect()->back();
        }
        else
        {
            return view('barcodes.printbarcode',compact('barcode'));
        }
    }
}
