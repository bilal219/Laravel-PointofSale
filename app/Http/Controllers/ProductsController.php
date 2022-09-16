<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use DB;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }
    public function currentstock()
    {
        $cat=Category::where('cat_status','=','Y')->get();
        return view('Stock.currentstock',compact('cat'));
    }
    public function expired()
    {
        $cat=Category::where('cat_status','=','Y')->get();
        return view('Stock.expired',compact('cat'));
    }
    public function reorder()
    {
        $cat=Category::where('cat_status','=','Y')->get();
        return view('Stock.reorder',compact('cat'));
    }
    public function loadstock(Request $request)
    {

        $cat_id=$request->cat_id;
        $stock=DB::table('products')
        ->select('products.product_name', 'products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
        ->join('categories','categories.id','=','products.cat_id')
        ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
        ->where('product_status','=','Y')
        ->get();
        if($cat_id!="")
        {
          $stock=DB::table('products')
          ->select('products.product_name', 'products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
          ->join('categories','categories.id','=','products.cat_id')
          ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
          ->where('products.cat_id','=',$cat_id)
          ->where('product_status','=','Y')
          ->get();
        }
        $stock_data='';
        if($stock->count()>0)
        {
            $stock_data .='<table id="current_stock" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>Cost price</th>
                    <th>Total Cost</th>
                    <th>Retail Price</th>
                    <th>Total Retail</th>
                </tr>
            </thead>
            <tbody>';   
            foreach($stock as $key=>$stock_info)
            {
            $sr=$key+1;
            $stock_data .='<tr>
            <td>'.$sr.'</td>
             <td>'.$stock_info->product_name.'</td>
             <td>'.$stock_info->UPC_EAN.'</td>
             <td>'.$stock_info->cat_name.'</td>
             <td>'.$stock_info->uom_name.'</td>
             <td>'.$stock_info->qty.'</td>
             <td>'.$stock_info->costprice.'</td>
             <td>'.($stock_info->costprice*$stock_info->qty).'</td>
             <td>'.$stock_info->fretailprice.'</td>
             <td>'.($stock_info->fretailprice*$stock_info->qty).'</td>
            </tr>';
            }
            $stock_data .='</tbody></table>';
            echo $stock_data;
        }
        else 
        {
          echo '<h1 class="text-center text-secondary my-5">No record present in the database related your search!</h1>';
        }
    }

    public function loadreorder(Request $request)
    {

        $cat_id=$request->cat_id;
        $stock=DB::table('products')
        ->select('products.product_name', 'products.reorder_qty','products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
        ->join('categories','categories.id','=','products.cat_id')
        ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
        ->where('product_status','=','Y')
        ->get(); 
        if($cat_id!="")
        {
          $stock=DB::table('products')
          ->select('products.product_name','products.reorder_qty', 'products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
          ->join('categories','categories.id','=','products.cat_id')
          ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
          ->where('products.cat_id','=',$cat_id)
          ->where('product_status','=','Y')
          ->get();
        }
        $stock_data='';
        if($stock->count()>0)
        {
            $stock_data .='<table id="current_stock" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>Cost price</th>
                    <th>Total Cost</th>
                    <th>Retail Price</th>
                    <th>Total Retail</th>
                </tr>
            </thead>
            <tbody>';   
            foreach($stock as $key=>$stock_info)
            {
                if($stock_info->qty<=$stock_info->reorder_qty)
                {
                    $sr=$key+1;
                    $stock_data .='<tr>
                    <td>'.$sr.'</td>
                    <td>'.$stock_info->product_name.'</td>
                    <td>'.$stock_info->UPC_EAN.'</td>
                    <td>'.$stock_info->cat_name.'</td>
                    <td>'.$stock_info->uom_name.'</td>
                    <td>'.$stock_info->qty.'</td>
                    <td>'.$stock_info->costprice.'</td>
                    <td>'.($stock_info->costprice*$stock_info->qty).'</td>
                    <td>'.$stock_info->fretailprice.'</td>
                    <td>'.($stock_info->fretailprice*$stock_info->qty).'</td>
                    </tr>';
                }
            }
            $stock_data .='</tbody></table>';
            echo $stock_data;
        }
        else 
        {
          echo '<h1 class="text-center text-secondary my-5">No record present in the database related your search!</h1>';
        }
    }

    public function loadexpired(Request $request)
    {

        $cat_id=$request->cat_id;
        $stock=DB::table('products')
        ->select('products.product_name','products.expirydate' , 'products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
        ->join('categories','categories.id','=','products.cat_id')
        ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
        ->where('product_status','=','Y')
        ->where('expirydate','<', Carbon::now())
        ->get();
        if($cat_id!="")
        {
          $stock=DB::table('products')
          ->select('products.product_name','products.expirydate' ,'products.UPC_EAN', 'products.qty', 'products.costprice', 'products.fretailprice', 'categories.cat_name', 'u_o_m_s.uom_name')
          ->join('categories','categories.id','=','products.cat_id')
          ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
          ->where('products.cat_id','=',$cat_id)
          ->where('expirydate','<', Carbon::now())
          ->where('product_status','=','Y')
          ->get();
        }
        $stock_data='';
        if($stock->count()>0)
        {
            $stock_data .='<table id="current_stock" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Product Name</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>Cost price</th>
                    <th>Total Cost</th>
                    <th>Retail Price</th>
                    <th>Total Retail</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>';   
            foreach($stock as $key=>$stock_info)
            {
            $sr=$key+1;
            
            $stock_data .='
            <tr>
             <td>'.$sr.'</td>
             <td>'.$stock_info->product_name.'</td>
             <td>'.$stock_info->UPC_EAN.'</td>
             <td>'.$stock_info->cat_name.'</td>
             <td>'.$stock_info->uom_name.'</td>
             <td>'.$stock_info->qty.'</td>
             <td>'.$stock_info->costprice.'</td>
             <td>'.($stock_info->costprice*$stock_info->qty).'</td>
             <td>'.$stock_info->fretailprice.'</td>
             <td>'.($stock_info->fretailprice*$stock_info->qty).'</td>
             <td>'.Carbon::parse($stock_info->expirydate)->format('d-M-Y').'</td>
            </tr>';
            }
            $stock_data .='</tbody></table>';
            echo $stock_data;
        }
        else 
        {
          echo '<h1 class="text-center text-secondary my-5">No record present in the database related your search!</h1>';
        }
    }
    //auto generate barcode
    public function auto_gen_barcode()
    {
        $upc_ean = random_int(100000, 999999);
        return response($upc_ean);
    }

    public function addproduct(Request $request)
    {
        $fileName="";
        $file=$request->file('product_image');
        if($file)
        {
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/product_images',$fileName);
        }
       $stock_manage="Y";
       if($request->dont_stock_manage)
       {
        $stock_manage="N";
       }
       $product=new Product;
       $product->product_name=$request->product_name;
       $product->generic_name=$request->generic_name;
       $product->UPC_EAN=$request->upc_ean;
       $product->product_image=$fileName;
       if($request->apply_expiry)
       {
        $product->expirydate=$request->expiry_date;
       }
       $product->cat_id=$request->cat_id;
       $product->uom_id=$request->uom_id;
       $product->UPC_EAN=$request->upc_ean;
       $product->manage_stock=$stock_manage;
       $product->qty=$request->opening_qty;
       $product->reorder_qty=$request->reorder_qty;
       $product->inventory="Y";
       $product->product_status="Y";
       $product->costprice=$request->cost_price;
       $product->retailprice=$request->retail_price;
       $product->discount=$request->discount;
       $product->fretailprice=$request->final_price;
       if($request->supplier)
       {
        $product->supp_id=$request->supp_id;
       }
        $product->save();
       return response($product);
    }

    //fetch products
    public function fetchproducts()
    {
        $product = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.cat_id')
        ->select('products.*', 'categories.cat_name')
        ->where('products.product_status','=','Y')
        ->get();
       $pro_data='';
       if($product->count()>0)
       {
           $pro_data .='<table id="add-row" class="display table-sm table-striped table-hover" style="width:100%">
           <thead>
               <tr>
                   <th>Sr#</th>
                   <th>Image</th>
                   <th>Product Name</th>
                   <th>Barcode</th>
                   <th>Category</th>
                   <th>Cost</th>
                   <th>Retail Price</th>
                   <th>Quantity</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>';   
           foreach($product as $key=>$list)
           {
            $image_path="/assets/img/default.png";
            if($list->product_image)
            {
                $image_path="storage/images/product_images/$list->product_image";
            }
           $sr=$key+1;
           $pro_data .='<tr>
           <td>'.$sr.'</td>           
           <td><div class="avatar avatar-xs"><img src='.$image_path.' class="avatar-img rounded-circle"/></div></td>
            <td>'.$list->product_name.'</td>
            <td>'.$list->UPC_EAN.'</td>
            <td>'.$list->cat_name.'</td>
            <td>'.$list->costprice.'</td>
            <td>'.$list->retailprice.'</td>
            <td>'.$list->qty.'</td>
            <td>
                <a href="#" type="button" id="'.$list->id.'" data-toggle="modal" data-target="#editproductModal" title="" class="text-primary mr-1 fa fa-edit editproducticon" data-original-title="Edit Task">
                </a>
                <a href="#" type="button" id="'.$list->id.'" data-toggle="tooltip" title="" class="text-danger fa fa-times ml-1 deleteproducticon" data-original-title="Remove">
                </a>
            </td>
           </tr>';
           }
           $pro_data .='</tbody></table>';
           echo $pro_data;
       }
       else 
       {
         echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
       }
    }
    //edit products
    public function editproduct(Request $request)
    {
        $id=$request->id;
        $pro=Product::find($id);
        return response()->json($pro);
    }
    //update Product

    public function updateproduct(Request $request)
    {
        $fileName;
        $pro=Product::find($request->pro_id);
        if($request->hasFile('product_image'))
        {
            $file=$request->file('product_image');
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/product_images/',$fileName);
            if($pro->product_image)
            {
               unlink('storage/images/product_images/'.$pro->product_image);
            }
        }
        else
        {
            $fileName=$pro->product_image;
        }
        $stock_manage="Y";
       if($request->dont_stock_manage)
       {
        $stock_manage="N";
       }
       $pro->product_name=$request->product_name;
       $pro->generic_name=$request->generic_name;
       $pro->UPC_EAN=$request->upc_ean;
       $pro->product_image=$fileName;
       if($request->apply_expiry)
       {
        $pro->expirydate=$request->expiry_date;
       }
       $pro->cat_id=$request->cat_id;
       $pro->uom_id=$request->uom_id;
       $pro->UPC_EAN=$request->upc_ean;
       $pro->manage_stock=$stock_manage;
       $pro->qty=$request->opening_qty;
       $pro->reorder_qty=$request->reorder_qty;
       $pro->inventory="Y";
       $pro->product_status="Y";
       $pro->costprice=$request->edit_cost_price;
       $pro->retailprice=$request->retail_price;
       $pro->discount=$request->discount;
       $pro->fretailprice=$request->final_price;
       if($request->supplier)
       {
        $pro->supp_id=$request->supp_id;
       }
        // $proData=[
        //     'product_image'=>$fileName,
        //     'manage_stock'=>$stock_manage,
        //     'product_name'=>$request->product_name,
        //     'generic_name'=>$request->generic_name,
        //     'UPC_EAN'=>$request->upc_ean,
        //     'expirydate'=>$request->expiry_date,
        //     'cat_id'=>$request->cat_id,
        //     'uom_id'=>$request->uom_id,
        //     'qty'=>$request->opening_qty,
        //     'cost_price'=>$request->edit_cost_price,
        //     'retail_price'=>$request->retail_price,
        //     'discount'=>$request->discount,
        //     'final_price'=>$request->final_price,
        //     'reorder_qty'=>$request->reorder_qty,
        //     'supp_id'=>$request->supp_id,
        // ];
        $pro->save();
        return response()->json(
            [
            'status'=>200,
            ]
        );
    }
    //delete product

    public function productdelete(Request $request)
    {
        $id=$request->id;
        $pro=Product::find($id);
        $pro_Data=[
            'product_status'=>'N',
        ];
        $pro->update($pro_Data);
        return response()->json([
            'status'=> 200
        ]);
    }
    
}
