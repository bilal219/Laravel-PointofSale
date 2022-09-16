<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\InvoiceNo;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\SupplierAccount;
use App\Models\PurchaseReturnDetail;
use App\Models\PurchaseReturn;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class PurchaseController extends Controller
{
    public function purchase()
    {
        return view('Purchase.addpurchase');
    }
    public function purchaseinvoice()
    {
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->purchase_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->purchase_invoice_no=$add_inv->purchase_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('purchase_invoice_no')->first();
        return response()->json($inv_no);
    }
    //add to cart
    public function addtopurchasecart(Request $request){
        $status=200;
        $total_price=$request->purchase_qty*$request->cost_price;
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
        $cart = session()->get('purchasecart', []);
        if(isset($cart[$pid]))
        {    
            $cart[$pid]['purchase_qty']=$cart[$pid]['purchase_qty']+$request->purchase_qty;  
            if($request->expiry_date=="")
            {
            $cart[$pid]['expiry_date']="";
            }else{$cart[$pid]['expiry_date']=$request->expiry_date;}
        }
        else
        {
            $cart[$pid] = [
                "prod_id" => $products->id,
                "product_name" => $products->product_name,
                "upc_ean" => $products->UPC_EAN,
                "qty" => $products->qty,
                "purchase_qty" =>$request->purchase_qty ,
                "cost_price" => $request->cost_price,
                "retail_price" =>$request->retail_price ,
                "expiry_date" => $request->expiry_date,
                "fretail_price" => $products->fretailprice,
            ];
        }
    
        session()->put('purchasecart', $cart);
        return response()->json([
            'status'=>$status
        ]);
    }
// remove from cart
public function removefrompurchasecart(Request $request)
{
    $id=$request->id;
    if(session('purchasecart'))
    {
        $cart = session('purchasecart'); 
        foreach($cart as $key => $value)
        {
            if($key == $id)
            {
                unset($cart [$key]);
            }
        }
    }
    session()->put('purchasecart', $cart);
    return response()->json([
        'status'=>200
    ]);      
}
    //load purchase cart
    public function loadpurchasecart()
    {  $cartdata='';
        $order_total=0;
       // $cart = session()->get('cart', []);
       if(session('purchasecart'))
       {
           foreach(session('purchasecart') as $pid=>$details)
           {
            // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
            // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
               $order_total+=($details['cost_price'] * $details['purchase_qty']);
               $cartdata.='<tr id="'.$pid.'">
               <td style="width:5%">'.$details['product_name'].'</td>
               <td style="width:5%">'.$details['upc_ean'].'</td>
               <td style="width:5%">'.$details['qty'].'</td>
               <td style="width:5%"><div class="d-flex">
                   <input class="form-control form-control-sm" value="'.$details['purchase_qty'].'" readonly><div>
                  
               </td>
               <td style="width:5%">'.$details['cost_price'].'</td>
               <td style="width:5%">'.$details['retail_price'].'</td>
               <td style="width:5%">'.($details['cost_price'] * $details['purchase_qty']).'</td>
               <td style="width:5%">'.$details['expiry_date'].'</td>
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
    //empty cart
    public function emptypurchasecart()
    {
        $cart = session()->flash('purchasecart', []);
        return response()->json([
            'status'=>200
        ]);
    }
    //complete purchase
    public function completepurchase(Request $request)
    {
        $status=200;
        $supp_id=$request->supp_id;
        $refrence_no=$request->refrence_no;
        $date=$request->date;
        $cart = session()->get('purchasecart');
        $invoice_no=$request->invoice_no;
        $total_price=0;
        if(session('purchasecart'))
        {
            if($supp_id)
            {
                //purchase detail
                foreach ($cart as $item) 
                {
                    $prod_id=$item['prod_id'];
                    $total_price += $item['cost_price'] * $item['purchase_qty'];
                    $totalprice=$item['cost_price'] * $item['purchase_qty'];
                    $totalfretail=$item['cost_price'] * $item['fretail_price'];
                    $detail=new PurchaseDetail();
                    $detail->prod_id=$prod_id;
                    $detail->Invoice_no=$invoice_no;
                    $detail->prod_name=$item['product_name'];
                    $detail->UPC_EAN=$item['upc_ean'];
                    $detail->QTY=$item['purchase_qty'];
                    $detail->cost_price=$item['cost_price'];
                    $detail->total_cost=$totalprice;
                    $detail->supp_id=$supp_id;
                    $detail->status="Completed";

                    //stock movement
                    $stockmovement=new StockMovement;
                    $stockmovement->prod_id=$prod_id;
                    $stockmovement->supp_id=$supp_id;
                    $stockmovement->qty=$item['purchase_qty'];
                    $stockmovement->cost_price=$item['cost_price'];
                    $stockmovement->total_cost=$totalprice;
                    $stockmovement->fretail_price=$item['fretail_price'];
                    $stockmovement->total_fretail=$totalfretail;
                    $stockmovement->invoice_no=$invoice_no;
                    $stockmovement->stock_status='Stock In';
                    $stockmovement->status='Y';

                    // prod quantity deduction
                    $prod=Product::where('id','=',$prod_id)->first();
                    $prod->qty+=$item['purchase_qty'];
                    $prod->expirydate=$item['expiry_date'];;
                    $prod->save();
                    $detail->save();
                    $stockmovement->save();
                }

                //purchase
                $purchase=new Purchase();
                $purchase->invoice_no=$invoice_no;
                $purchase->supp_id=$supp_id;
                $purchase->refrence_no=$refrence_no;
                $purchase->user_id=Auth::user()->id;
                $purchase->purchase_date=$date;
                $purchase->order_total=$total_price;
                $purchase->status="Completed";

                //account data entering
                $supp_account=new SupplierAccount();
                $supp_account->total_bill_amount=$total_price;
                $supp_account->paid_amount=0;
                $supp_account->supp_invoice_no=$invoice_no;
                $supp_account->supp_id=$supp_id;
                $supp_account->payment_method="By Cash";
                $supp_account->payment_type="paid_by_company";
                $supp_account->balance=$total_price-0;
                $supp_account->supp_acc_date=Carbon::now();
                $supp_account->save();
                
                $purchase->save();

            }else{$status=202;}
        }
        else{
            $status=404;
        }
        return response()->json($status);
    }
    //invoice list view 
    public function purchaselist()
    {
        return view('invoices.purchaseinvoicelist');
    }
    //get invoice list data 
    public function getpurchaseinvoices(Request $request)
    {
        $dtp_from=$request->from;
       $dtp_to=$request->to;
        $inv_data = DB::table('purchases')
        ->select('purchases.invoice_no','purchases.purchase_date','purchases.order_total')
        ->whereDate('purchases.purchase_date', '>=',$dtp_from)
        ->whereDate('purchases.purchase_date', '<=', $dtp_to)
        ->where('purchases.status','=','Completed')
        ->get();
        
        $inv_lists='';
            if($inv_data->count()>0)
            {
                $inv_lists .='<table id="purch_inv_lists" class="display table-sm table-striped table-hover"style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.#</th>
                        <th>Invoice.#</th>
                        <th>Order Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>';   
                foreach($inv_data as $key=>$inv_info)
                {
                $sr=$key+1;
                $inv_lists .='<tr>
                <td>'.$sr.'</td>
                <td>'.$inv_info->invoice_no.'</td>
                <td>'.$inv_info->order_total.'</td>
                <td>'.Carbon::parse($inv_info->purchase_date)->format('d-M-Y').'</td>
               
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
    //purchase return
    public function purchasereturn(Request $request)
    {
        return view('Purchase.purchasereturn');
    }
    //add to purchase return product cart
    public function addtopurchreturncart(Request $request)
    {
        $status=200;
        $id=$request->preturn_prod_id;
        if($id=="")
        {
            $prod=Product::where('product_name','=',$request->purchase_return_prod_name)
            ->orWhere('UPC_EAN','=',$request->purchase_return_prod_name)
            ->orWhere('id','=',$request->purchase_return_prod_name)
            ->first();
            $id=$prod->id;
        }
        $pid=$id;
        $products = Product::find($id);
        $cart = session()->get('purchasereturncart', []);
        if(isset($cart[$pid]))
        {    
            $cart[$pid]['return_qty']=$cart[$pid]['return_qty']+$request->return_qty;  
        }
        else
        {
            $cart[$pid] = [
                "prod_id" => $products->id,
                "product_name" => $products->product_name,
                "upc_ean" => $products->UPC_EAN,
                "availavble_qty" => $products->qty,
                "return_qty" => $request->purch_return_qty,
                "price" => $products->costprice,
                "fretail_price" => $products->fretailprice,
            ];
        }
        session()->put('purchasereturncart', $cart);
        return response()->json([
            'status'=>$status
        ]);
    }

    //load purchase return cart
    public function loadpurchasereturncart(Request $request)
    {
        $cartdata='';
        $order_total=0;
       // $cart = session()->get('cart', []);
       if(session('purchasereturncart'))
       {
           foreach(session('purchasereturncart') as $pid=>$details)
           {
            // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
            // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
               $order_total+=($details['price'] * $details['return_qty']);
               $cartdata.='
               <tr id="'.$pid.'">
                   <td>'.$details['product_name'].'</td>
                   <td>'.$details['upc_ean'].'</td>
                   <td>'.$details['availavble_qty'].'</td>
                   <td>'.$details['return_qty'].'</td>
                   <td>'.$details['price'].'</td>
                   <td>'.($details['price'] * $details['return_qty']).'</td>
                   <td><center><a href="#" id="'.$pid.'" class="text-danger mx-1 delpurchreturnitem"><i class="fa fa-times"></i></a><center></td>
               </tr>';
           }
       }
       return response()->json([
           'cart'=>$cartdata,
           'order_total'=>$order_total,
       ]);
    }

    // remove from cart
    public function removepurchitem(Request $request)
    {
        $id=$request->id;
        if(session('purchasereturncart'))
        {
            $cart = session('purchasereturncart'); 
            foreach($cart as $key => $value)
            {
                if($key == $id)
                {
                    unset($cart[$key]);
                }
            }
        }
        session()->put('purchasereturncart', $cart);
        return response()->json([
            'status'=>200
        ]);      
    }
    //purchase inline change
    public function inlinePurchasechange(Request $request)
    {
        $pid=$request->id;
        $qty=$request->qty;
        $cart = session()->get('purchasereturncart', []);
        if(isset($cart[$pid]))
        {    
          $cart[$pid]['return_qty']=$qty;  
        }
        session()->put('purchasereturncart', $cart);
        return response()->json(['status'=>200]);
    }
    //purchase return invoice_no
    public function purchasereturninvoice()
    {
        $count=InvoiceNo::count();
       if($count==0)
       { 
        $add_inv=new InvoiceNo;
        $add_inv->purch_return_invoice=1;
        $add_inv->save();
       }else if($count==1)
       {
        $add_inv=InvoiceNo::find(1);
        $add_inv->purch_return_invoice+=1;
        $add_inv->update();
       }
       $inv_no=InvoiceNo::select('purch_return_invoice')->first();
       return response()->json($inv_no);
    }
    //empty purchase return cart
    public function emptypurchasereturncart()
    {
        $cart = session()->flash('purchasereturncart', []);
        return response()->json([
            'status'=>200
        ]);
    }
    //complete purchase return
    public function completepurchasereturn(Request $request)
    {
        $status=200;
        $supp_id=$request->supp_id;
        $refrence_no=$request->refrence_no;
        $date=$request->date;
        $cart = session()->get('purchasereturncart');
        $invoice_no=$request->invoice_no;
        $total_price=0;
        if(session('purchasereturncart'))
        {
            if($supp_id)
            {

                //purchase detail
                foreach ($cart as $item) 
                {
                    $prod_id=$item['prod_id'];
                    $total_price += $item['price'] * $item['return_qty'];
                    $total_fretail = $item['fretail_price'] * $item['return_qty'];
                    $totalprice=$item['price'] * $item['return_qty'];
                    $detail=new PurchaseReturnDetail();
                    $detail->prod_id=$prod_id;
                    $detail->user_id=Auth::user()->id;
                    $detail->supp_id=$supp_id;
                    $detail->Invoice=$invoice_no;
                    $detail->return_qty=$item['return_qty'];
                    $detail->price=$item['price'];
                    $detail->total_price=$totalprice;
                    $detail->return_detail_status="Complete";
                    
                    //product qty decreasing
                    $prod=Product::where('id','=',$prod_id)->first();
                    $prod->qty-=$item['return_qty'];

                    //add to stockmovement
                    $stockmovement=new StockMovement;
                    $stockmovement->prod_id=$prod_id;
                    $stockmovement->supp_id=$supp_id;
                    $stockmovement->qty=$item['return_qty'];
                    $stockmovement->cost_price=$item['price'];
                    $stockmovement->total_cost=$totalprice;
                    $stockmovement->fretail_price=$item['fretail_price'];
                    $stockmovement->total_fretail=$total_fretail;
                    $stockmovement->invoice_no=$invoice_no;
                    $stockmovement->stock_status='Stock Out';
                    $stockmovement->status='Y';

                    $detail->save();
                    $prod->save();    
                    $stockmovement->save();    
                }

                //purchase
                $purchase=new PurchaseReturn();
                $purchase->user_id=Auth::user()->id;
                $purchase->return_amount=$total_price;
                $purchase->supp_id=$supp_id;
                $purchase->status="Comlpete";
                $purchase->return_invoice_no=$invoice_no;

                //account data entering
                $supp_account=new SupplierAccount();
                $supp_account->total_bill_amount=$total_price;
                $supp_account->paid_amount=0;
                $supp_account->supp_invoice_no=$invoice_no;
                $supp_account->supp_id=$supp_id;
                $supp_account->payment_method="By Cash";
                $supp_account->payment_type="paid_by_company";
                $supp_account->balance=$total_price-0;
                $supp_account->supp_acc_date=Carbon::now();
                $supp_account->save();
                $purchase->save();

            }else{$status=202;}
        }
        else{
            $status=404;
        }
        return response()->json($status);
    }

    // purchaseturn invoice
    public function prinvautocomplete(Request $request)
    {
        $term=$request->term;
        $data=DB::table('purchase_details')
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
    public function addtopinvoicecart(Request $request)
    {
        $cart = session()->forget('invoicepreturncart');
        $invoice_no=$request->search_invoice;
        $pur_detail=PurchaseDetail::where('invoice_no','=',$invoice_no)->get();
        $cart = session()->get('invoicepreturncart', []);
        foreach ($pur_detail as $details) 
        {
            $pid=$details->prod_id;
            $cart[$pid] = [
                "prod_id" => $details->prod_id,
                "product_name" => $details->prod_name,
                "purchase_qty" => $details->QTY,
                "return_qty" => 0,
                "price" => $details->cost_price,
                "supp_id" => $details->supp_id,
            ];
            session()->put('invoicepreturncart', $cart);
        }
        return response()->json([
            'status'=>200
        ]);
    }

    //load salereturn invoice cart
    public function loadpinvoicereturncart(Request $request)
    {
        $cartdata='';
        $order_total=0;
       // $cart = session()->get('cart', []);
       if(session('invoicepreturncart'))
       {
           foreach(session('invoicepreturncart') as $pid=>$details)
           {
                // <a href="#" id="'.$pid.'" class="text-danger mx-2 mt-1 minus_cart"><i class="fa fa-minus"></i></a>
                // <a href="#" id="'.$pid.'" class="text-success mx-2 plus_cart"><i class="fa fa-plus"></i></a>
               $order_total+=($details['price'] * $details['return_qty']);
               $tran_qty=$details['purchase_qty']-$details['return_qty'];
               $cartdata.='
               <tr id="'.$pid.'">
                   <td>'.$details['product_name'].'</td>
                   <td>'.$details['purchase_qty'].'</td>
                   <td>'.$details['return_qty'].'</td>
                   <td>'.$tran_qty.'</td>
                   <td>'.$details['price'].'</td>
                   <td>'.($details['price'] * $details['return_qty']).'</td>
                   <td><center><a href="#" id="'.$pid.'" class="text-danger mx-1 delpurinvoiceitem"><i class="fa fa-times"></i></a><center></td>
               </tr>';
           }
       }
       return response()->json([
           'cart'=>$cartdata,
           'order_total'=>$order_total,
       ]);
    }


    public function removepurinvoicereturn(Request $request)
    {
        $id=$request->id;
        if(session('invoicepreturncart'))
        {
            $cart = session('invoicepreturncart'); 
            foreach($cart as $key => $value)
            {
                if($key == $id)
                {
                    unset($cart[$key]);
                }
            }
        }
        session()->put('invoicepreturncart', $cart);
        return response()->json([
            'status'=>200
        ]);   
    }

    //inlinepurchaseinvoicechange
    public function inlinepurinvoicechange(Request $request)
    {
        $pid=$request->id;
        $qty=$request->qty;
        $cart = session()->get('invoicepreturncart', []);
        if(isset($cart[$pid]))
        {    
        $cart[$pid]['return_qty']=$qty;  
        }
        session()->put('invoicepreturncart', $cart);
        return response()->json(['status'=>200]);
    }

    //purchase return empty cart
    public function emptypurchaseinvreturncart()
    {
        $cart = session()->flash('invoicepreturncart', []);
        return response()->json([
            'status'=>200
        ]);
    }

    //product invoice checkout
    public function purchaseinvoicereturn(Request $request)
    {
        $status=200;
        $total_profit=0;
        $invoice=$request->invoice_no;
        $return_invoice_no=$request->return_invoice_no; 
        $cart = session()->get('invoicepreturncart');
        if(session('invoicepreturncart'))
        {
            $return_total=0;
            foreach ($cart as $item) 
            {
                //Purchase return detail
                $supp_id=$item['supp_id'];
                $return_qty=$item['return_qty'];
                $detail=new PurchaseReturnDetail();
                $return_total+=($item['price'] * $item['return_qty']);
                $total=($item['price'] * $item['return_qty']);
                $detail->prod_id=$item['prod_id'];
                $detail->user_id=Auth::user()->id;
                $detail->invoice=$return_invoice_no;
                $detail->return_qty=$item['return_qty'];
                $detail->price=$item['price'];
                $detail->total_price=$total;
                $detail->supp_id=$supp_id;
                $detail->return_detail_status='Complete';
                $detail->save();

                //Purchase details
                $pur_details=PurchaseDetail::where('Invoice_no','=',$invoice)
                ->where('prod_id','=',$item['prod_id'])
                ->where('supp_id','=',$supp_id)
                ->first();
                $pur_details->QTY-=$return_qty;
                $pur_details->total_cost-=$total;
                $pur_details->save();

                //stockmovement
                $stockmovement=new StockMovement;
                $stockmovement->prod_id=$item['prod_id'];
                $stockmovement->supp_id=$supp_id;
                $stockmovement->qty=$return_qty;
                $stockmovement->cost_price=$item['price'];
                $stockmovement->total_cost=$total;
                $stockmovement->invoice_no=$return_invoice_no;
                $stockmovement->stock_status='Stock Out';
                $stockmovement->status='Y';
                
                //update product Quantity
                $id=$item['prod_id'];
                $product=Product::find($id);
                $product->qty-=$item['return_qty'];
                $stockmovement->save();
                $product->save();
            }
            //Purchase Update
            $purchase=Purchase::where('invoice_no','=',$invoice)->first();
            $purchase->order_total-=$return_total;
            $supp_id=$purchase->supp_id;

            $account=SupplierAccount::where('supp_id','=',$supp_id)
            ->where('supp_invoice_no','=',$invoice)
            ->first();
            $account->total_bill_amount-=$return_total;
            $account->balance=($account->total_bill_amount-$account->paid_amount);
            $account->save();
          
            //Return
            $return=new PurchaseReturn();
            $return->user_id=Auth::user()->id;
            $return->return_amount=$return_total;
            $return->status='Completed';
            $return->return_invoice_no=$return_invoice_no;
            $return->save();
            $purchase->save();
        }
        else
        {
            $status=202;
        }
        echo $status;
    }

    //purchase return list
    public function purchasereturnlist(Request $request)
    {
        return view('Purchase.purchasereturnlist');
    }

    // fetch detail
    public function getpurchasereturnlist(Request $request)
    {
        $dtp_from=$request->from;
        $dtp_to=$request->to;
        $inv_data = DB::table('purchase_returns')
        ->select('return_invoice_no', 'return_amount', 'created_at')
        ->distinct('return_invoice_no')
        ->whereDate('created_at', '>=',$dtp_from)
        ->whereDate('created_at', '<=', $dtp_to)
        ->where('status','=','Completed')
        ->groupBy('return_invoice_no')
        ->orderBy('id','asc')
        ->get();
        
        $inv_lists ='<table id="PR_lists" class="display table-sm table-striped table-hover"style="width:100%">
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
                        <a href="#" id="'.$inv_info->return_invoice_no.'" data-toggle="tooltip" title="" class="fa fa-receipt text-danger ml-1 viewPR_detail" data-original-title="Remove">
                        </a>
                    </td>
                </tr>';
            }
        }
        $inv_lists .='</tbody></table>';
        echo $inv_lists;
    }

    //get detail
    public function purchasereturndetail(Request $request)
    {
        $tqty=0;
        $Treturnamount=0;
        $invoice_no=$request->invoice;
        $return_detail=DB::table('purchase_return_details')
        ->select('products.product_name', DB::raw("sum(purchase_return_details.return_qty) as return_qty"), 'purchase_return_details.price', DB::raw("sum(purchase_return_details.total_price) as total_price"))
        ->join('products','purchase_return_details.prod_id','=','products.id')
        ->where('purchase_return_details.invoice','=',$invoice_no)
        ->groupBy('products.product_name')
        ->get();
        $data='
        <strong>
            <h4 class="text-secondary">'.$invoice_no.'</h4>
        </strong>
        <div class="text-center mb-4">
            <h4 class="text-primary"><b><u>Purchase Return Detail</u></b></h4>
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
}
