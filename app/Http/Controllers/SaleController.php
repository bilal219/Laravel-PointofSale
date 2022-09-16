<?php

namespace App\Http\Controllers;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\InvoiceNo;
use App\Models\CashRegister;
use App\Models\CustomerAccount;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\ChequeInfo;
use App\Models\InvoiceConfig;
use App\Models\ClientDetails;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
class SaleController extends Controller
{
    //auto complete
    public function autocomplete(Request $request)
    {
        $term=$request->term;
        $data=DB::table('products')
        ->select('id','product_name', 'UPC_EAN', 'product_image','expirydate', 'fretailprice','costprice')
        ->where('product_name','LIKE','%'.$term.'%')
        ->orWhere('UPC_EAN','LIKE','%'.$term.'%')
        ->orWhere('id','LIKE','%'.$term.'%')
        ->get();
        foreach ($data as $key => $v) {

            $results[]=array('value'=>$v->UPC_EAN,'label'=>$v->UPC_EAN ." | \n  ".$v->product_name." | \n  ".$v->fretailprice,'prod_name'=>$v->product_name,'prod_price'=>$v->fretailprice,'cost_price'=>$v->costprice,'prod_id'=>$v->id,'expiry_date'=>$v->expirydate);
  
        }
  
        return response()->json($results);
    }    
    public function cashregister()
    {
        return view('sale.cashregister');
    }

    //pos index

    public function index()
    {
        $register = CashRegister::select('id','status')->where('user_id',Auth::user()->id)->where('status','=','Open')->latest()->first();
        if(!$register)
        {
            return view('Sale.cashregister');

        }else{

            return view('Sale.pos');
        }
    }
    // invoice generator
    public function invoice_generator()
    {
       $count=InvoiceNo::count();
       if($count==0)
       { 
        $add_inv=new InvoiceNo;
        $add_inv->invoice_no=1;
        $add_inv->save();
       }else if($count==1)
       {
        $add_inv=InvoiceNo::find(1);
        $add_inv->invoice_no+=1;
        $add_inv->update();
       }
       $inv_no=InvoiceNo::select('invoice_no')->first();
       return response()->json($inv_no);
    }
    public function fetchall()
    {
        $catoutput='<option value="">--Select Category--</option>';
        $prodoutput='';
        $custoutput='';
        $categories=Category::select('id','cat_name')->where('cat_status','=','Y')->get();
        $customers=Customer::select('id','cust_name')->where('status','=','Y')->get();
        $products=Product::select('id','product_name','UPC_EAN','product_image')->where('product_status','=','Y')->get();
        foreach($products as $prod_data)
        {
            $src="";
             if($prod_data->product_image)
             {
                $src="storage/images/product_images/$prod_data->product_image";
             }
             else{
                $src="/assets/img/default.png";
             }
            $prodoutput.='<div class="col-md-4">
            <a href="#" id="'.$prod_data->id.'" class="addgridcart">
                <div class="">
                <div class="card-body">
                        <center>
                            <div class="avatar">
                                <img src='.$src.' class="img-fluid avatar-img rounded" alt="">
                            </div>
                            <br><span style="font-size: 14px;">'.$prod_data->product_name.'</span><br><span style="font-size: 14px;">('.$prod_data->UPC_EAN.')</span>
                        </center>
                    </div>
                </div>
            </a>
        </div> ';

        }
        foreach($categories as $cat_data)
        {$catoutput.='<option value="'.$cat_data->id.'">'.$cat_data->cat_name.'</option>';}
        foreach($customers as $cust_data)
        {$custoutput.='<option value="'.$cust_data->id.'">'.$cust_data->cust_name.'</option>';}
        
        return response()->json([
         'categories'=>$catoutput,
         'customers'=>$custoutput,
         'products'=>$prodoutput,
        ]);
    }
    //fetch Category wise Products
    public function fetchprods(Request $request)
    {         
        $id=$request->id;
        $prodoutput='';
        $prodcuts='';
        if($id=="")
        {
            $products=Product::select('id','product_name','UPC_EAN','product_image')->where('product_status','=','Y')->get();
        }
        else
        {
            $products=Product::select('id','product_name','UPC_EAN','product_image')->where('cat_id','=',$id)->where('product_status','=','Y')->get();
        }
        foreach($products as $prod_data)
        {
            $src="";
             if($prod_data->product_image)
             {
                 $src="storage/images/product_images/$prod_data->product_image";
             }
             else{
                 $src="/assets/img/default.png";
             }
            $prodoutput.='<div class="col-md-4">
            <a href="#" id="'.$prod_data->id.'" class="addgridcart">
                <div class="card card-round">
                <div class="card-body">
                        <center>
                            <div class="avatar">
                                <img src='.$src.' class="img-fluid avatar-img rounded" alt="">
                            </div>
                            <br><span style="font-size: 14px;">'.$prod_data->product_name.'</span><br><span style="font-size: 14px;">('.$prod_data->UPC_EAN.')</span>
                        </center>
                    </div>
                </div>
            </a>
        </div> ';

        }
       echo $prodoutput;
    }
    public function fetchcustinfo(Request $request)
    {
        $cust_info=Customer::select('cust_name','contact')->where('id','=',$request->id)->where('status','=','Y')->first();
        return response()->json($cust_info);
    }
    //fetch product information
    public function fetchproinfo(Request $request)
    {
        $pro_info=Product::select('product_name','retailprice')->where('id','=',$request->id)->where('product_status','=','Y')->first();
        return response()->json($pro_info);
    }
    public function searchproducts(Request $request)
    {
        $product = DB::table('products')
        ->where('products.product_status','=','Y')
        ->select('products.product_name','products.upc_ean','products.id')->get();
        return response()->json($product);
    }
    public function addtocart(Request $request)
    {
        $status=200;
        $id=$request->prod_id;
        $unitprice=$request->unitprice;
        $fretail=$request->unitprice;
        if($id=="")
        {
            $prod=Product::where('product_name','=',$request->search_name)
            ->orWhere('UPC_EAN','=',$request->search_name)
            ->orWhere('id','=',$request->search_name)
            ->first();
            $id=$prod->id;
            $products = Product::find($id);
            $unitprice=$products->retailprice;
            $fretail=$products->fretailprice;
        }
        $pid=$id;
        $products = Product::find($id);
        $cart = session()->get('cart', []);
        if ($request->qty > $products->qty){$status=201;}
        else
        {
            if(isset($cart[$pid]))
            {
                $diff = $products->qty - $cart[$pid]['qty'];
                if ($request->qty > $diff) {
                    $status=202;
                }
                else
                {
                    $cart[$pid]['qty']=$cart[$pid]['qty']+$request->qty;
                    $cart[$pid]['retail_price']=$unitprice;
                }    
           }
           else
           {
               $cart[$pid] = [
                   "product_name" => $products->product_name,
                   "prod_id" => $products->id,
                   "upc_ean" => $products->UPC_EAN,
                   "discount" => $products->discount,
                   "qty" => $request->qty,
                   "retail_price" => $unitprice,
                   "fretail_price" => $fretail,
                   "cost_price" => $products->costprice,
                   "id" => $products->id
               ];
           }
        }
        session()->put('cart', $cart);
        return response()->json([
            'status'=>$status
         ]);
    }

    public function addcartgrid(Request $request)
    {
        $status=200;
        $id=$request->id;
        $pid=$id;
        $grid_qty=1;
        $products = Product::find($id);
        $cart = session()->get('cart', []);
        if ($grid_qty > $products->qty){$status=201;}
        else
        {
            if(isset($cart[$pid]))
            {
                $diff = $products->qty - $cart[$pid]['qty'];
                if ($grid_qty > $diff) {
                    $status=202;
                }
                else
                {
                    $cart[$pid]['qty']=$cart[$pid]['qty']+$grid_qty;
                }    
           }
           else
           {
               $cart[$pid] = [
                   "product_name" => $products->product_name,
                   "prod_id" => $products->id,
                   "upc_ean" => $products->UPC_EAN,
                   "discount" => $products->discount,
                   "qty" => $grid_qty,
                   "retail_price" => $products->retailprice,
                   "fretail_price" => $products->fretailprice,
                   "cost_price" => $products->costprice,
               ];
           }
        }
        session()->put('cart', $cart);
        return response()->json([
            'status'=>$status
         ]);
    }

    public function loadcart()
    {  $cartdata='';
        $order_total=0;
       // $cart = session()->get('cart', []);
       if(session('cart'))
       {
           foreach(session('cart') as $pid=>$details)
           {
            // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
            // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
               $order_total+=($details['fretail_price'] * $details['qty']);
               $cartdata.='<tr id="'.$pid.'">
               <td style="width:5%">'.$details['product_name'].'</td>
               <td style="width:5%">
               <a href="#" class="text-danger fa fa-minus ml-2 minus-cart" id="'.$pid.'"></a>
               <small>'.$details['qty'].'</small>
               <a href="#" class="text-success fa fa-plus mr-2 plus-cart" id="'.$pid.'"></a>
               </td>
               <td style="width:5%">'.$details['retail_price'].'</td>
               <td style="width:5%">'.$details['discount'].'</td>
               <td style="width:5%">'.(($details['retail_price']-$details['discount']) * $details['qty']).'</td>
               <td style="width:5%"> 
                <center><a href="#" id="'.$pid.'" class="text-danger mx-1 delfromcarticon"><i class="fa fa-times"></i></a><center>
              </td>
           </tr>';
           }
       }
        return response()->json([
            'cart'=>$cartdata,
            'order_total'=>$order_total,
        ]);
    }

    // remove from cart
    public function removefromcart(Request $request)
    {
        $id=$request->id;
        if(session('cart'))
        {
            $cart = session('cart'); 
            foreach($cart as $key => $value)
            {
                if($key == $id)
                {
                    unset($cart [$key]);
                }
            }
        }
        session()->put('cart', $cart);
        return response()->json([
            'status'=>200
        ]);      
    }
    //empty cart
    public function emptycart()
    {
        $cart = session()->flash('cart', []);
        return response()->json([
            'status'=>200
        ]);
    }
    // sale checkout
    public function salecheckout(Request $request)
    {                      
        $cart = session()->get('cart');
        $invoice_no=$request->invoice_no;
        $totalcost=0;
        $prev_balance=$request->prev_balance;
        $cal_net_payable=$request->net_payable-$prev_balance;
        $balance=$cal_net_payable-$request->payment_amount;
        $status=200;
        if(session('cart'))
        {   
            if($request->cust_id ==1 && ($request->payment_amount < $request->net_payable))
            {$status=201;} 
            else
            {
                foreach ($cart as $item) 
                {
                    $totalcost += $item['cost_price'] * $item['qty'];
                }
                // adding to sale 
                $sale = new Sale();
                $sale->user_id = Auth::user()->id;
                $sale->sale_date = Carbon::now();
                $sale->cust_id = $request->cust_id;
                $sale->invoice_no = $invoice_no;
                $sale->discount = $request->discount_amount;
                $sale->order_total = $request->order_total;
                $sale->total_amount = $cal_net_payable;
                // $sale->total_amount = $request->net_payable;
                $sale->payment_amount = $request->payment_amount;
                // $sale->change_amount = $request->change_amount;
                $sale->change_amount =$request->payment_amount - $cal_net_payable;
                // $sale->profit = $request->net_payable - $totalcost;
                $sale->profit = $cal_net_payable - $totalcost;
                $sale->status = "Complete";
                $sale->payment_method = "Cash";
                $sale->save();
                // details
                foreach ($cart as $item) 
                {
                    //calculation
                    $total_cost=$item['cost_price']*$item['qty'];
                    $total_fretail=$item['fretail_price']*$item['qty'];
                    $profit=$total_fretail-$total_cost;

                    //decreasing qty in products
                    $id=$item['prod_id'];
                    $product = new Product();
                    $subqty = $product->find($id);
                    $subqty->qty -= $item['qty'];

                    //adding to sale details
                    $saledetail = new SaleDetail();
                    $saledetail->invoice_no = $invoice_no;
                    $saledetail->product_id = $item['prod_id'];
                    $saledetail->customer_id = $request->cust_id;
                    $saledetail->product_name = $item['product_name'];
                    $saledetail->discount = $item['discount'];
                    $saledetail->qty = $item['qty'];
                    $saledetail->cost_price = $item['cost_price'];
                    $saledetail->retail_price = $item['retail_price'];
                    $saledetail->fretail_price = $item['fretail_price'];
                    $saledetail->total_costprice =  $total_cost;
                    $saledetail->total_fretailprice =  $total_fretail;
                    $saledetail->profit =  $profit;
                    $saledetail->user_id =  Auth::user()->id;
                    $saledetail->status =  "Complete";
                    $saledetail->save();
                    $subqty->save();
                }  
                //accounts
                $cust_account=new CustomerAccount();
                $cust_account->total_bill_amount=$cal_net_payable;
                $cust_account->paid_amount=$request->payment_amount;
                $cust_account->cust_invoice_no=$invoice_no;
                $cust_account->cust_id=$request->cust_id;
                $cust_account->payment_method="By Cash";
                $cust_account->payment_type="received_in_company";
                $cust_account->balance=$balance;
                $cust_account->cust_acc_date=Carbon::now();
                $cust_account->save();   
            }
        }
        else if(!session('cart'))
        {$status=202;}

        return response()->json([
            'status'=>$status,
        ]) ;
    }

    public function invoiceprint(Request $request)
    {
        $rcpt_name="Technors POS";
        $engstatus=false;
        $urdustatus=false;
        $rcpt_address="Mumtaz Market Gujranwala";
        $rcpt_name_urdu="ٹیکنورز پوائنٹ آف سیل سسٹم";
        $rcpt_address_urdu="ممتاز مارکیٹ گوجرانوالہ";
        $rcpt_contact="+92(3)111 122 144";
        $image="/tminvoicelogo.png";
        $config=Clientdetails::latest('id')->first();
        if($config)
        {
           $rcpt_name=$config->Bus_Name;
           $rcpt_name_urdu=$config->Bus_Name_Ur;
           $rcpt_address=$config->Bus_Address;
           $rcpt_address_urdu=$config->Bus_Address_Ur;
           $rcpt_contact=$config->Bus_Contact1;
        }
        $inv_config=InvoiceConfig::latest('id')->first();
        if($inv_config)
        {
            if($inv_config->sale_inv_language==="English")
            {
               $engstatus=true;
            }
            else if($inv_config->sale_inv_language==="urdu")
            {
                $urdustatus=true;
            }
            if($inv_config->sale_inv_logo)
            {
                $image="storage/images/invoicelogo/$inv_config->sale_inv_logo";
            }
        }
        
        $invoice="";
        $invoice_no=$request->invoice;
        $total_qty=0;
        $old_balance=0;
        $sale=DB::table('sales')
        ->select('customers.cust_name','users.name', 'customers.address','sales.cust_id','sales.created_at' ,'customers.contact','sales.order_total','sales.total_amount', 'sales.discount', 'sales.payment_method', 'sales.payment_amount', 'sales.change_amount')
        ->leftJoin('customers','customers.id','=','sales.cust_id')
        ->leftJoin('users','users.id','=','sales.user_id')
        ->where('sales.invoice_no','=',$invoice_no)
        ->first();
        //   sale details
        
        $saledetail=DB::table('sale_details')
        ->select('products.product_name', 'sale_details.qty', 'sale_details.discount', 'sale_details.fretail_price', 'sale_details.total_fretailprice')
        ->join('sales','sales.invoice_no','=','sale_details.invoice_no')
        ->join('products','products.id','=','sale_details.product_id')
        ->where('sale_details.invoice_no','=',$invoice_no)
        ->get();
        
        $prev_balance=DB::table('customer_accounts')
        ->where('cust_id','=',$sale->cust_id)
        ->where('id','<',function($query) use($invoice_no) {
            $query->from('customer_accounts')
            ->select('id')
            ->where('cust_invoice_no','=',$invoice_no);
        })
        ->sum('balance');
        if($prev_balance)
        {
            $old_balance=$prev_balance;
        }
         
        if($engstatus==true || !$inv_config)
        {
            $invoice='
            <div class="col-md-12">
                <div class="row">
                    <div id="invoice_logo" class="mb-3 mx-auto" style="max-width:120px;max-height:120px">
                        <img src='.$image.' class="img-fluid">
                    </div>
                </div>
                <div class="text-center mb-3">
                    <div id="comp_logo_name">
                        <h4 class="pt-0 mt-3"><strong>'.$rcpt_name.'</strong></h4>
                    </div>
                    <h5>'.$rcpt_address.'</h5>
                    <h6>'.$rcpt_contact.'</h6>
                    <p></p>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-sm-7">
                    <ul class="list-unstyled float-left">
                        <li class="text-muted">Customer :&nbsp;<span style="color:#5d9fc5 ;">'.$sale->cust_name.'</span></li>
                        <li class="text-muted">Served By:&nbsp;<span style="color:#5d9fc5 ;">'.$sale->name.'</span></li>
                        <li class="text-muted">Receipt # :&nbsp;<span style="color:#5d9fc5 ;">'.$invoice_no.'</span></li>
                    </ul>
                </div>
                <div class="col-sm-5">
                    <ul class="list-unstyled float-right">
                    <li class="text-muted"><span
                    class="fw-bold">Date:&nbsp;</span>'.Carbon::parse($sale->created_at)->format('d-M-Y').'</li>
                    <li class="text-muted">Ph #</i>&nbsp;'.$sale->contact.'</li>
                   </ul>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table style="width:100%" class="table-sm table-striped table-bordered table-condensed">
                                    <thead style="background-color:#84B0CA ;" class="text-white">
                                        <tr>
                                            <td><strong>Description</strong></td>
                                            <td class="text-center"><strong>Qty</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-right"><strong>Total Price</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        foreach($saledetail as $key=>$data){
                                            $total_qty+=$data->qty;
                                            $invoice.='
                                            <tr>
                                                <td>'.$data->product_name.'</td>
                                                <td class="text-center">'.$data->qty.'</td>
                                                <td class="text-center">'.$data->fretail_price.'</td>
                                                <td class="text-right">'.$data->total_fretailprice.'</td>
                                            </tr>';
                                        }                 
                                     $invoice.='
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><b>Total Items</b></td>
                                            <td class="text-center"> <b>'.$total_qty.'</b></td>
                                            <td class="text-center"></td>
                                            <td class="text-right">'.$sale->order_total.'</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
                            </div>
                            <div class="d-flex">
                                <div class="col-sm-12 text-left">
                                    <table class"table-sm table-condensed">
                                        <tbody>
                                            <tr>
                                                <td>Order Total :</td>
                                                <td class="text-right pl-4">'.$sale->order_total.'</td>
                                            </tr>
                                            <tr>
                                                <td>Discount :</td>
                                                <td class="text-right pl-4">'.$sale->discount.'</td>
                                            </tr>
                                            <tr>
                                                <td>Previous Balance :</td>
                                                <td class="text-right pl-4">'.$old_balance.'</td>
                                            </tr>
                                            <tr>
                                                <td>Net Payable :</td>
                                                <td class="text-right pl-4">'.($sale->total_amount +$old_balance).'</td>
                                            </tr>
                                            <tr>
                                                <td>Received :</td>
                                                <td class="text-right pl-4">'.$sale->payment_amount.'</td>
                                            </tr>
                                            <tr>
                                                <td>Change :</td>
                                                <td class="text-right pl-4">'.($sale->payment_amount-($sale->total_amount +$old_balance)).'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4">
                                <hr>
                                <center>';
                                    $invoice.=
                                        DNS1D::getBarcodeSVG($request->invoice, "C128",1.4,50);                                
                                    $invoice.=' 
                                </center>
                            </div>
                            <div>
                                <div class="col-xl-6 mx-auto mt-2">
                                    <h5 class="text-center m-0">Thank you for your visit</h5>
                                    <h6 class="text-center m-0"><b>Software Developed with love by</b></h6>
                                    <h6 class="text-center m-0">Technic Mentors | 0300-4900046</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }else if($urdustatus)
        {
            $invoice='
            <div class="col-md-12">
                <div class="row">
                    <div id="invoice_logo" class="mb-2 mx-auto">
                        <img src='.$image.' class="img-fluid" style="max-width:120px;max-height:120px">
                    </div>
                </div>
                <div class="text-center my-2">
                    <div id="comp_logo_name" class="mt-2">
                        <h4 class=""><strong>'.$rcpt_name_urdu.'</strong></h4>
                    </div>
                    <h5>'.$rcpt_address_urdu.'</h5>
                    <h6>'.$rcpt_contact.'</h6>
                    <p></p>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-sm-7">
                    <ul class="list-unstyled float-left">
                        <li class="text-muted">کسٹمر :&nbsp;<span style="color:#5d9fc5 ;">'.$sale->cust_name.'</span></li>
                        <li class="text-muted">نمائندہ :&nbsp;<span style="color:#5d9fc5 ;">'.$sale->name.'</span></li>
                        <li class="text-muted">رسید نمبر :&nbsp;<span style="color:#5d9fc5 ;">'.$invoice_no.'</span></li>
                    </ul>
                </div>      
                <div class="col-sm-5">
                    <ul class="list-unstyled float-right">
                    <li class="text-muted"><span>'.Carbon::parse($sale->created_at)->format('d-M-Y').'<span> : تاریخ</li>
                    <li class="text-muted"><span>'.$sale->contact.'</span> : فون نمبر</li>
                   </ul>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Order summary</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table style="width:100%" class="table-sm table-striped table-bordered table-condensed">
                                    <thead style="background-color:#84B0CA ;" class="text-white">
                                        <tr>
                                            <td class="text-center"><strong>ٹوٹل</strong></td>
                                            <td class="text-center"><strong>قیمت</strong></td>
                                            <td class="text-center"><strong>مقدار</strong></td>
                                            <td class="text-right"><strong>تفصیل</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        foreach($saledetail as $key=>$data){
                                            $total_qty+=$data->qty;
                                            $invoice.='
                                            <tr>
                                            <td class="text-center">'.$data->total_fretailprice.'</td>
                                            <td class="text-center">'.$data->fretail_price.'</td>
                                            <td class="text-center">'.$data->qty.'</td>
                                            <td class="text-right">'.$data->product_name.'</td>
                                            </tr>';
                                        }                 
                                     $invoice.='
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <td class="text-center">'.$sale->order_total.'</td>
                                        <td class="text-center"> <b>'.$total_qty.'</b></td>
                                        <td class="text-center"></td>
                                        <td class="text-right"><b>ٹوٹل آئٹم</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
                            </div>
                            <div class="d-flex">
                                <div class="ml-auto text-right">
                                    <table class"table-sm table-condensed">
                                        <tbody>
                                            <tr>
                                                <td class="text-right pr-4">'.$sale->order_total.'</td>
                                                <td>: آرڈر ٹوٹل</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right pr-4">'.$sale->discount.'</td>
                                                <td>: ڈسکاؤنٹ</td>
                                            </tr>
                                            <tr>
                                            <td class="text-right pr-4">'.$old_balance.'</td>
                                                <td>: سابقہ بقایا</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right pr-4">'.$sale->total_amount.'</td>
                                                <td>: قابل ادائیگی</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right pr-4">'.$sale->payment_amount.'</td>
                                                <td>: وصول</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right pr-4">'.$sale->change_amount.'</td>
                                                <td>: بقایا جات</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-4">
                                <hr>
                                <center>';
                                    $invoice.=
                                        DNS1D::getBarcodeSVG($request->invoice, "C128",1.4,50);                                
                                    $invoice.=' 
                                </center>
                            </div>
                            <div>
                                <div class="col-xl-6 mx-auto mt-2">
                                    <h5 class="text-center m-0">Thank you for your visit</h5>
                                    <h6 class="text-center m-0"><b>Software Developed with love by</b></h6>
                                    <h6 class="text-center m-0">Technic Mentors | 0300-4900046</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
       echo $invoice; 
    }

    public function invoices()
    {
        return view('Invoices.saleinvoice');
    }

    public function getinvoices(Request $request){
       $dtp_from=$request->from;
       $dtp_to=$request->to;
        $inv_data = DB::table('sales')
        ->select('sales.invoice_no','sales.created_at','sales.total_amount','sales.payment_method','customers.cust_name')
        ->join('customers','customers.id','=','sales.cust_id')
        ->whereDate('sales.created_at', '>=',$dtp_from)->whereDate('sales.created_at', '<=', $dtp_to)
        ->where('sales.status','=','Complete')
        ->get();
        
        $inv_lists='';
            if($inv_data->count()>0)
            {
                $inv_lists .='<table id="inv_lists" class="display table-sm table-striped table-hover"style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>Invoice.#</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';   
                foreach($inv_data as $key=>$inv_info)
                {
                $sr=$key+1;
                $inv_lists .='<tr>
                <td>'.$sr.'</td>
                <td>'.$inv_info->invoice_no.'</td>
                <td>'.$inv_info->cust_name.'</td>
                <td>'.$inv_info->total_amount.'</td>
                <td>'.Carbon::parse($inv_info->created_at)->format('d-M-Y').'</td>
                <td>'.$inv_info->payment_method.'</td>
                <td>
                    
                    <a href="#" id="'.$inv_info->invoice_no.'" data-toggle="tooltip" title="" class="fa fa-receipt text-danger ml-1 viewinvoice" data-original-title="Remove">
                    </a>
                </td>
                </tr>';
                }
                $inv_lists .='</tbody></table>';
                echo $inv_lists;
            }
            else 
        {
        echo '<h1 class="text-center text-secondary my-5">No record present in the database for this Date range!</h1>';
        }
    }
    //open register
    public function openregister(Request $request)
    {
        $register=new Cashregister();
        $register->user_id=Auth::user()->id;
        $register->opening_date=Carbon::now();
        $register->cash_in_hand=$request->cash_in_hand;
        $register->status="Open";
        $register->save();
       return redirect()->back();
    }
    //check openclose
    public function chkclose()
    {
        $status=200;
        $register = CashRegister::select('id','status')->where('user_id',Auth::user()->id)->where('status','=','Open')->latest()->first();
        if(!$register){
        $status=404;
        }
        return response()->json([
            'status'=>$status
        ]);
        
    }
    //cash close view
    public function cashclose()
    {  
        $sales_total=0;
        $chequestotal=0;
        $totalreturn=0;     
        $reg=CashRegister::select('cash_in_hand','opening_date')
        ->where('status','=','Open')->where('user_id','=',Auth::user()->id)
        ->latest()->first();
        //sales
        $total_sales=DB::table('sales')
        ->select(DB::raw("SUM(total_amount) as total_amount"))
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('sale_date','>=',$reg->opening_date)
        ->whereDate('sale_date','<=',Carbon::now())
        ->get();
        //Cheque Infos
        $chqamount=ChequeInfo::where('status','=','Cleared')
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('chq_date','>=',$reg->opening_date)
        ->whereDate('chq_date','<=',Carbon::now())
        ->sum('chq_amount');
        //SaleReturn
        $returnamount=SaleReturn::where('user_id','=',Auth::user()->id)
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('created_at','>=',$reg->opening_date)
        ->whereDate('created_at','<=',Carbon::now())
        ->sum('return_amount');
        if($returnamount)
        {
            $totalreturn=$returnamount;
        }
        if($chqamount)
        {
            $chequestotal=$chqamount;
        }
        $cash_in_hand=$reg->cash_in_hand;
        if($total_sales[0]->total_amount)
        {
            $sales_total=$total_sales[0]->total_amount;
        }
        $closing_amount=$cash_in_hand + $sales_total+$chequestotal-$totalreturn;
        return view('Sale.cashclose',compact('reg','sales_total','closing_amount','chequestotal','totalreturn'));
    }
    //close register
    public function closeregister(Request $request)
    {
       $register=CashRegister::where('user_id','=',Auth::user()->id)
       ->where('status','=','Open')->latest()->first();
       $register->closing_date=Carbon::now();
       $register->status="Close";
       $register->total_sale=$request->total_sales;
       $register->total_return=$request->total_return;
       $register->closing_amount=$request->closing_amount;
       $register->save();
       return response()->json([
        'status'=>200
       ]);
    }
    //sale return view 
    public function salereturn()
    {
        return view('Sale.salesreturn');
    }
    //sale return cart
    public function addtoreturncart(Request $request)
    {
        $status=200;
        $id=$request->prod_id;
        if($id=="")
        {
            $prod=Product::where('product_name','=',$request->search_name)
            ->orWhere('UPC_EAN','=',$request->search_name)
            ->orWhere('id','=',$request->search_name)
            ->first();
            $id=$prod->id;
        }
        $pid=$id;
        $products = Product::find($id);
        $cart = session()->get('salereturncart', []);
        if(isset($cart[$pid]))
        {    
            $cart[$pid]['return_qty']=$cart[$pid]['return_qty']+$request->return_qty;  
        }
        else
        {
            $cart[$pid] = [
                "prod_id" => $products->id,
                "product_name" => $products->product_name,
                "return_qty" => $request->return_qty,
                "price" => $products->fretailprice,
            ];
        }
    
        session()->put('salereturncart', $cart);
        return response()->json([
            'status'=>$status
        ]);
    }

     //load purchase cart
     public function loadreturncart()
     {  $cartdata='';
         $order_total=0;
        // $cart = session()->get('cart', []);
        if(session('salereturncart'))
        {
            foreach(session('salereturncart') as $pid=>$details)
            {
             // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
             // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
                $order_total+=($details['price'] * $details['return_qty']);
                $cartdata.='
                <tr id="'.$pid.'">
                    <td>'.$details['product_name'].'</td>
                    <td>'.$details['return_qty'].'</td>
                    <td>'.$details['price'].'</td>
                    <td>'.($details['price'] * $details['return_qty']).'</td>
                    <td><center><a href="#" id="'.$pid.'" class="text-danger mx-1 delreturnitem"><i class="fa fa-times"></i></a><center></td>
                </tr>';
            }
        }
        return response()->json([
            'cart'=>$cartdata,
            'order_total'=>$order_total,
        ]);
    }

    // remove from cart
    public function removesalereturn(Request $request)
    {
        $id=$request->id;
        if(session('salereturncart'))
        {
            $cart = session('salereturncart'); 
            foreach($cart as $key => $value)
            {
                if($key == $id)
                {
                    unset($cart[$key]);
                }
            }
        }
        session()->put('salereturncart', $cart);
        return response()->json([
            'status'=>200
        ]);      
    }
    //inline changing
    public function inlinechange(Request $request)
    {
      $pid=$request->id;
      $qty=$request->qty;
      $cart = session()->get('salereturncart', []);
      if(isset($cart[$pid]))
      {    
        $cart[$pid]['return_qty']=$qty;  
      }
      session()->put('salereturncart', $cart);
      return response()->json(['status'=>200]);
    }
    //empty return cart  
    public function emptyreturncart()
    {
        $cart = session()->flash('salereturncart', []);
        return response()->json([
            'status'=>200
        ]);
    }
    public function salereturninvoice()
    {
        $count=InvoiceNo::count();
       if($count==0)
       { 
        $add_inv=new InvoiceNo;
        $add_inv->sale_return_invoice=1;
        $add_inv->save();
       }else if($count==1)
       {
        $add_inv=InvoiceNo::find(1);
        $add_inv->sale_return_invoice=$add_inv->sale_return_invoice+1;
        $add_inv->update();
       }
       $inv_no=InvoiceNo::select('sale_return_invoice')->first();
       return response()->json($inv_no);
    }

    //product checkout
    public function productreturn(Request $request)
    {
        $status=200;
        $invoice=$request->invoice_no;
        $cart = session()->get('salereturncart');
        if(session('salereturncart'))
        {
            $return_total=0;
            foreach ($cart as $item) 
            {
                //return detail
                $detail=new SaleReturnDetail();
                $return_total+=($item['price'] * $item['return_qty']);
                $total=($item['price'] * $item['return_qty']);
                $detail->prod_id=$item['prod_id'];
                $detail->user_id=Auth::user()->id;
                $detail->invoice=$invoice;
                $detail->return_qty=$item['return_qty'];
                $detail->price=$item['price'];
                $detail->total_price=$total;
                $detail->return_detail_status='Complete';
                
                //update product Quantity
                $id=$item['prod_id'];
                $product=Product::find($id);
                $product->qty+=$item['return_qty'];
                $product->save();
                $detail->save();

            }
            //Return
            $return=new SaleReturn();
            $return->user_id=Auth::user()->id;
            $return->return_amount=$return_total;
            $return->status='Completed';
            $return->return_invoice_no=$invoice;
            $return->save();
        }
        else
        {
            $status=202;
        }
        echo $status;
    }
    //product invoice checkout
    public function productinvoicereturn(Request $request)
    {
        $status=200;
        $total_profit=0;
        $invoice=$request->invoice_no;
        $return_invoice_no=$request->return_invoice_no; 
        $cart = session()->get('invoicereturncart');
        if(session('invoicereturncart'))
        {
            $return_total=0;
            foreach ($cart as $item) 
            {
                //return detail
                $detail=new SaleReturnDetail();
                $return_total+=($item['price'] * $item['return_qty']);
                $total=($item['price'] * $item['return_qty']);
                $detail->prod_id=$item['prod_id'];
                $detail->user_id=Auth::user()->id;
                $detail->invoice=$return_invoice_no;
                $detail->return_qty=$item['return_qty'];
                $detail->price=$item['price'];
                $detail->total_price=$total;
                $detail->return_detail_status='Complete';
                $detail->save();

                //sale details
                $sale_details=SaleDetail::where('invoice_no','=',$invoice)
                ->where('product_id','=',$item['prod_id'])->first();
                $profit=$sale_details->profit-($total-($sale_details->cost_price*$item['return_qty']));
                $total_profit+=$profit;
                $sale_details->qty-=$item['return_qty'];
                $sale_details->total_fretailprice-=$total;
                $sale_details->profit=$profit;
                $sale_details->save();

                //update product Quantity
                $id=$item['prod_id'];
                $product=Product::find($id);
                $product->qty+=$item['return_qty'];
                $product->save();
            }
            //sale Update
            $sale=Sale::where('invoice_no','=',$invoice)->first();
            $sale->order_total-=$return_total;
            $sale->total_amount-=($sale->discount+$return_total);
            $sale->change_amount=($sale->payment_amount-$sale->total_amount);
            $sale->profit=$total_profit;
            $cust_id=$sale->cust_id;

            $account=CustomerAccount::where('cust_id','=',$cust_id)
            ->where('cust_invoice_no','=',$invoice)
            ->first();
            $account->total_bill_amount-=$return_total;
            $account->balance=($account->total_bill_amount-$account->paid_amount);
            $account->save();
          
            //Return
            $return=new SaleReturn();
            $return->user_id=Auth::user()->id;
            $return->return_amount=$return_total;
            $return->status='Completed';
            $return->return_invoice_no=$return_invoice_no;
            $return->save();
            $sale->save();
        }
        else
        {
            $status=202;
        }
        echo $status;
    }
    //invoice salereturn autocomplete
    public function srinvautocomplete(Request $request)
    {
        $term=$request->term;
        $data=DB::table('sale_details')
        ->select('invoice_no')
        ->where('invoice_no','LIKE','%'.$term.'%')
        ->where('status','=','Complete')
        ->distinct('invoice_no')
        ->get();
        foreach ($data as $key => $v)
        {

            $results[]=array('value'=>$v->invoice_no,'label'=>$v->invoice_no);
  
        }
  
        return response()->json($results);
    }

    // add to invoice return cart
    public function addtoinvoicecart(Request $request)
    {
        $cart = session()->forget('invoicereturncart');
        $invoice_no=$request->search_invoice;
        $sale_detail=SaleDetail::where('invoice_no','=',$invoice_no)->get();
        $cart = session()->get('invoicereturncart', []);
        foreach ($sale_detail as $details) 
        {
            $pid=$details->product_id;
            $cart[$pid] = [
                "prod_id" => $details->product_id,
                "product_name" => $details->product_name,
                "sold_qty" => $details->qty,
                "return_qty" => 0,
                "price" => $details->fretail_price,
            ];
            session()->put('invoicereturncart', $cart);
        }
        return response()->json([
            'status'=>200
        ]);
    }
    //load salereturn invoice cart
    public function loadinvoicereturncart(Request $request)
    {
        $cartdata='';
        $order_total=0;
       // $cart = session()->get('cart', []);
       if(session('invoicereturncart'))
       {
           foreach(session('invoicereturncart') as $pid=>$details)
           {
            // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
            // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
               $order_total+=($details['price'] * $details['return_qty']);
               $tran_qty=$details['sold_qty']-$details['return_qty'];
               $cartdata.='
               <tr id="'.$pid.'">
                   <td>'.$details['product_name'].'</td>
                   <td>'.$details['sold_qty'].'</td>
                   <td>'.$details['return_qty'].'</td>
                   <td>'.$tran_qty.'</td>
                   <td>'.$details['price'].'</td>
                   <td>'.($details['price'] * $details['return_qty']).'</td>
                   <td><center><a href="#" id="'.$pid.'" class="text-danger mx-1 delinvoiceitem"><i class="fa fa-times"></i></a><center></td>
               </tr>';
           }
       }
       return response()->json([
           'cart'=>$cartdata,
           'order_total'=>$order_total,
       ]);
    }
    //inlineinvoicechange
    public function inlineinvoicechange(Request $request)
    {
        $pid=$request->id;
        $qty=$request->qty;
        $cart = session()->get('invoicereturncart', []);
        if(isset($cart[$pid]))
        {    
          $cart[$pid]['return_qty']=$qty;  
        }
        session()->put('invoicereturncart', $cart);
        return response()->json(['status'=>200]);
    }
    public function removesaleinvoicereturn(Request $request)
    {
        $id=$request->id;
        if(session('invoicereturncart'))
        {
            $cart = session('invoicereturncart'); 
            foreach($cart as $key => $value)
            {
                if($key == $id)
                {
                    unset($cart[$key]);
                }
            }
        }
        session()->put('invoicereturncart', $cart);
        return response()->json([
            'status'=>200
        ]);   
    }
    //empty invoice cart
    public function emptyinvoicecart()
    {
        $cart = session()->flash('invoicereturncart', []);
        return response()->json([
            'status'=>200
        ]);
    }
    //Cash Register Close
    public function poscashregister()
    {
        $sales_total=0;   
        $chequestotal=0;
        $totalreturn=0;   
        $reg=CashRegister::select('cash_in_hand','opening_date')->where('status','=','Open')->where('user_id','=',Auth::user()->id)->latest()->first();
        $total_sales=DB::table('sales')
        ->select(DB::raw("SUM(total_amount) as total_amount"))
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('sale_date','>=',$reg->opening_date)
        ->whereDate('sale_date','<=',Carbon::now())
        ->get();
        //Cheque Infos
        $chqamount=ChequeInfo::where('status','=','Cleared')
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('chq_date','>=',$reg->opening_date)
        ->whereDate('chq_date','<=',Carbon::now())
        ->sum('chq_amount');
        //SaleReturn
        $returnamount=SaleReturn::where('user_id','=',Auth::user()->id)
        ->where('user_id','=',Auth::user()->id)
        ->whereDate('created_at','>=',$reg->opening_date)
        ->whereDate('created_at','<=',Carbon::now())
        ->sum('return_amount');
        if($returnamount)
        {
            $totalreturn=$returnamount;
        }
        if($chqamount)
        {
            $chequestotal=$chqamount;
        }
        $cash_in_hand=$reg->cash_in_hand;
        if($total_sales[0]->total_amount)
        {
            $sales_total=$total_sales[0]->total_amount;
        }
        $closing_amount=$cash_in_hand+$sales_total+$chequestotal-$totalreturn;
        return response()->json([
            "sales_total"=>$sales_total,
            "cash_in_hand"=>$cash_in_hand,
            "closing_amount"=>$closing_amount,
            "cheque_total"=>$chequestotal,
            "return_amount"=>$totalreturn,
        ]);
    }
    public function holdinvoice(Request $request)
    {
        $cart = session()->get('cart');
        $invoice_no=$request->invoice_no;
        $totalcost=0;
        $balance=$request->net_payable-$request->payment_amount;
        $status=200;
        if(session('cart'))
        {   
            foreach ($cart as $item) 
            {
                $totalcost += $item['cost_price'] * $item['qty'];
            }
            // adding to sale 
            $sale = new Sale();
            $sale->user_id = Auth::user()->id;
            $sale->sale_date = Carbon::now();
            $sale->cust_id = $request->cust_id;
            $sale->invoice_no = $invoice_no;
            $sale->discount = $request->discount_amount;
            $sale->order_total = $request->order_total;
            $sale->total_amount = $request->net_payable;
            $sale->payment_amount = $request->payment_amount;
            $sale->change_amount = $request->change_amount;
            $sale->profit = $request->net_payable - $totalcost;
            $sale->status = "Hold";
            $sale->payment_method = "Cash";
            $sale->save();
            // details
            foreach ($cart as $item) 
            {
                //calculation
                $total_cost=$item['cost_price']*$item['qty'];
                $total_fretail=$item['fretail_price']*$item['qty'];
                $profit=$total_fretail-$total_cost;
                //adding to sale details
                $saledetail = new SaleDetail();
                $saledetail->invoice_no = $invoice_no;
                $saledetail->product_id = $item['prod_id'];
                $saledetail->customer_id = $request->cust_id;
                $saledetail->product_name = $item['product_name'];
                $saledetail->discount = $item['discount'];
                $saledetail->qty = $item['qty'];
                $saledetail->cost_price = $item['cost_price'];
                $saledetail->retail_price = $item['retail_price'];
                $saledetail->fretail_price = $item['fretail_price'];
                $saledetail->total_costprice =  $total_cost;
                $saledetail->total_fretailprice =  $total_fretail;
                $saledetail->profit =  $profit;
                $saledetail->user_id =  Auth::user()->id;
                $saledetail->status =  "Hold";
                $saledetail->save();
            }          
        }
        else if(!session('cart'))
        {$status=202;}
        return response()->json([
            'status'=>$status,
        ]) ;
    }
    //show hold invoices
    public function holdinvoiceslist(Request $request)
    {
        $inv_data = DB::table('sales')
        ->select('sales.invoice_no','sales.created_at','sales.total_amount','sales.payment_method')
        ->where('sales.status','=','Hold')
        ->get(); 
        $inv_lists='';
        if($inv_data->count()>0)
        {
            $inv_lists .='<table id="hold_inv_list" class="display table-sm table-striped table-hover"style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>Invoice.#</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody>';   
            foreach($inv_data as $key=>$inv_info)
            {
                $sr=$key+1;
                $inv_lists .='
                <tr>
                <td>'.$sr.'</td>
                <td>'.$inv_info->invoice_no.'</td>
                <td>'.$inv_info->total_amount.'</td>
                <td>'.Carbon::parse($inv_info->created_at)->format('d-M-Y').'</td>
                <td>'.$inv_info->payment_method.'</td>
                <td>
                    <a href="#" id="'.$inv_info->invoice_no.'" data-toggle="modal" data-target="#" title="" class="mx-1 text-primary editholdinvoice" data-original-title="Edit Task">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" id="'.$inv_info->invoice_no.'" data-toggle="tooltip" title="" class="mx-1 text-danger viewholdinvoice" data-original-title="Remove">
                        <i class="fa fa-receipt"></i>
                    </a>               
                </td>
                </tr>';
            }
            $inv_lists .='</tbody></table>';
            echo $inv_lists;
        }
        else 
        {
        echo '<h1 class="text-center text-secondary my-5">No record present in the database for this Date range!</h1>';
        }
    } 
    //inline changing
    public function posinlinechange(Request $request)
    {
      $status=200;
      $pid=$request->id;
      $qty=$request->qty;
      $cart = session()->get('cart', []);
      $products = Product::find($pid);
      if ($request->qty > $products->qty){$status=201;}
      else{
        if(isset($cart[$pid]))
        {    
            $cart[$pid]['qty']=$qty;  
        }
        session()->put('cart', $cart);
      }
      return response()->json(['status'=>$status,'prod'=>$products]);
    }
    // plus in cart
    public function plusincart(Request $request)
    {
        $pid=$request->id;
        $products = Product::find($pid);
        if(session('cart'))
        {
            $cart = session('cart'); 
            if(isset($cart[$pid]))
            {    
                if($cart[$pid]['qty'] < $products->qty)
                {
                    $cart[$pid]['qty']+=1;  
                    session()->put('cart', $cart);
                }
            }
        }
        return response()->json([
            'status'=>200
        ]);      
    }
    // minus from cart
    public function minusfromcart(Request $request)
    {
        $pid=$request->id;
        if(session('cart'))
        {
            $cart = session('cart'); 
            if(isset($cart[$pid]))
            {    if($cart[$pid]['qty'] > 1)
                {
                    $cart[$pid]['qty']-=1;  
                    session()->put('cart', $cart);
                }
            }
        }
        return response()->json([
            'status'=>200
        ]);      
    }
/*     Hold Invocie Load */
    public function loadholdinvoice(Request $request)
    {   
        $invoice = $request->invoice_no;
        $sale_detail = SaleDetail::where('invoice_no','=',$invoice)->where('status','=','Hold')->get();
        $cart = session()->get('cart', []);
        foreach ($sale_detail as $pid => $list)
        {
            $cart[$pid] = [
                "product_name" => $list->product_name,
                "prod_id" => $list->product_id,
                "discount" => $list->discount,
                "qty" => $list->qty,
                "retail_price" => $list->retail_price,
                "fretail_price" => $list->fretail_price,
                "cost_price" => $list->cost_price,
                "id" => $list->id
            ];
            session()->put('cart', $cart);
        }
        $sale = Sale::where('invoice_no','=',$invoice)->where('status','=','Hold')->first();

        return response()->json(["status"=>200,'sale'=>$sale]);
    }

    //sale return list
    public function salesreturnlist(){
        return view('Sale.salereturnlist');
    }

    // fetch detail
    public function getsalereturnlist(Request $request)
    {
        $dtp_from=$request->from;
        $dtp_to=$request->to;
        $inv_data = DB::table('sale_returns')
        ->select('return_invoice_no', 'return_amount', 'created_at')
        ->distinct('return_invoice_no')
        ->whereDate('created_at', '>=',$dtp_from)
        ->whereDate('created_at', '<=', $dtp_to)
        ->where('status','=','Completed')
        ->groupBy('return_invoice_no')
        ->orderBy('id','asc')
        ->get();
        
        $inv_lists ='<table id="SR_lists" class="display table-sm table-striped table-hover"style="width:100%">
        <thead>
        <tr>
            <th>Sr.#</th>
            <th>Invoice.#</th>
            <th>Return Amount</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>';   
        if($inv_data->count()>0)
        {
            foreach($inv_data as $key=>$inv_info)
            {
                $inv_lists .='
                <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$inv_info->return_invoice_no.'</td>
                    <td>'.$inv_info->return_amount.'</td>
                    <td>'.Carbon::parse($inv_info->created_at)->format('d-M-Y').'</td>
                    <td>
                        <a href="#" id="'.$inv_info->return_invoice_no.'" data-toggle="tooltip" title="" class="fa fa-receipt text-danger ml-1 viewSR_detail" data-original-title="Remove">
                        </a>
                    </td>
                </tr>';
            }
        }
        $inv_lists .='</tbody></table>';
        echo $inv_lists;
    }

    //get detail
    public function salereturndetail(Request $request)
    {
        $tqty=0;
        $Treturnamount=0;
        $invoice_no=$request->invoice;
        $return_detail=DB::table('sale_return_details')
        ->select('products.product_name', DB::raw("sum(sale_return_details.return_qty) as return_qty"), 'sale_return_details.price', DB::raw("sum(sale_return_details.total_price) as total_price"))
        ->join('products','sale_return_details.prod_id','=','products.id')
        ->where('sale_return_details.invoice','=',$invoice_no)
        ->groupBy('products.product_name')
        ->get();

         $data='
         <strong>
            <h4 class="text-secondary">'.$invoice_no.'</h4>
         </strong>
        <div class="text-center mb-4">
            <h4 class="text-primary"><b><u>Sale Return Detail</u></b></h4>
        </div>
        <div class="table-responsive mb-4">
            <table class="display table-sm table-hover table-striped table-condensed" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>Product Name</th>
                        <th class="text-center">Return Qty</th>
                        <th class="text-center">Price</th>
                        <th class="text-right">Total Price</th>    
                    </tr>
                </thead>
                <tbody>';
                foreach($return_detail as $key=>$details)
                {
                    $Treturnamount+=$details->total_price;
                    $tqty+=$details->return_qty;
                    $data.='
                    <tr>
                        <td>'.($key+1).'</td>
                        <td>'.$details->product_name.'</td>
                        <td class="text-center">'.$details->return_qty.'</td>
                        <td class="text-center">'.$details->price.'</td>
                        <td class="text-right"s>'.$details->total_price.'</td>   
                    </tr>';
                }
                $data.='
                </tbody>
                <tfoot class="mt-3">
                    <tr>
                        <td><b>Total Qty</b></td>
                        <td></td>
                        <td class="text-center"><b>'.$tqty.'</b></td>
                        <td></td>
                        <td class="text-right">'.$Treturnamount.'</td>   
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right">
            <b>Return Total :</b>  '.$Treturnamount.'
        </div>';
        echo $data;
    }
    
    // Invoice chnages
    public function addinvoicematerial(Request $request)
    {
        $fileName="";
        $file=$request->file('invoicelogo');
        if($file)
        {
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/invoicelogo',$fileName);
        }
      $config=new InvoiceConfig();
      if(InvoiceConfig::count()>0)
      {
        $config=InvoiceConfig::latest('id')->first();
        if($file)
        {
            if($config->sale_inv_logo)
            {
               unlink('storage/images/invoicelogo/'.$config->sale_inv_logo);
            }
        }
        else
        {
            $fileName=$config->sale_inv_logo;
        }
      }
      $config->sale_inv_language=$request->inv_language;
      $config->sale_inv_logo=$fileName;
      $config->save();
      return response()->json(['status'=>200]);
    }

    //get detail
    public function getinvdetail()
    {
        $img_tag='';
        $config_detail=InvoiceConfig::select('sale_inv_language','sale_inv_logo')
        ->latest('id')->first();
        if($config_detail->sale_inv_logo)
        {
          $image_path="storage/images/invoicelogo/$config_detail->sale_inv_logo";
          $img_tag='<a href="#" class="text-danger fa fa-times float-right" id="remove_img"></a><br><img src="'.$image_path.'" class="avatar-img">
          <br>';
        }
        return response()->json([
            'language'=>$config_detail->sale_inv_language,
            'img'=>$img_tag
        ]);

    }

    //del img
    public function delinvlogo()
    {
        $config=InvoiceConfig::latest('id')->first();
        if($config->sale_inv_logo)
        {
           unlink('storage/images/invoicelogo/'.$config->sale_inv_logo);
        }
        $config->sale_inv_logo=null;
        $config->save();
        return response()->json(['status'=>200]);
    }

    //load previous balance
    public function loadpreviousbalance(Request $request)
    {
        $prev_balance=DB::table('customer_accounts')
        ->select('id')
        ->where('cust_id','=',$request->cust_id)       
        ->sum('balance');
        return response()->json($prev_balance);
    }
}
  
    
             
             
