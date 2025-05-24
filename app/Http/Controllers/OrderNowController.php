<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use Illuminate\Http\Request;

class OrderNowController extends Controller
{
    public function ordernow(){
        
        return view('ordernow');
    }

    public function ordernowlist(){

        $product_list = AdminProduct::where('status','1')->get();
            return view('ordernow',[
            'product_lists' =>$product_list,
        ]);

    }

    public function productview(Request $request){
        $id = $request->query('id'); // Get the ?id=5 from URL

        $product = AdminProduct::findOrFail($id);

        return view('productview', compact('product'));
    }
}
