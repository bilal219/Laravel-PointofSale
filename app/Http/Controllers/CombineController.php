<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierAccount;
use App\Models\Customer;
use Carbon\Carbon;
use DB;

class CombineController extends Controller
{
    public function index(Request $request)
    {
        return view('combineaccount.combine');
    }
    public function singlecombineaccount(Request $request)
    {
      $total_bill_amount=0;
      $total_paid_amount=0;
      $total_balance=0;
      $output='
      <table id="single_combine" class="display table-sm table-striped table-hover example" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Total Bill Amount</th>
                    <th>Paid amount</th>
                    <th>Balance</th>
                    <th>Paymant Method</th>
                </tr>
            </thead>
        <tbody>';
        $cust_id=$request->cust_id;
        session()->forget('combine');
        $cust_acc=DB::table('customer_accounts')
        ->select('id','cust_invoice_no', 'total_bill_amount','balance', 'paid_amount', 'created_at', 'payment_method')
        ->where('cust_id','=',$cust_id)
        ->get();
        $supp_acc=DB::table('supplier_accounts')
        ->select('id','supp_invoice_no', 'total_bill_amount','balance', 'paid_amount', 'created_at', 'payment_method')
        ->where('supp_id','=',function($query) use($cust_id){
            $query->from('customers')
            ->select('supp_id')
            ->where('id','=',$cust_id);
        })
        ->get();
        $cart = session()->get('combine', []);
        foreach($cust_acc as $key=>$cust_data)
        {
            $cart[]= [
                "invoice" => $cust_data->cust_invoice_no,
                "total_bill_amount" => $cust_data->total_bill_amount,
                "paid_amount" => $cust_data->paid_amount,
                "date" => $cust_data->created_at,
                "balance" => $cust_data->balance,
                "pay_method" => $cust_data->payment_method,
            ];
            session()->put('combine', $cart);
        }
        foreach($supp_acc as $key=>$supp_data)
        {
            $cart[]= [
                "invoice" => $supp_data->supp_invoice_no,
                "total_bill_amount" => $supp_data->total_bill_amount,
                "paid_amount" => $supp_data->paid_amount,
                "date" => $supp_data->created_at,
                "balance" => $supp_data->balance,
                "pay_method" => $supp_data->payment_method,
            ];
            session()->put('combine', $cart);
        }
        $cartdata = session()->get('combine');
        if($cartdata)
        {
            foreach($cartdata as $key=>$combine)
            {
                $total_bill_amount+=$combine['total_bill_amount'];
                $total_paid_amount+=$combine['paid_amount'];
                $total_balance+=$combine['balance'];
                $output .='
                <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$combine['invoice'].'</td>
                    <td>'.Carbon::parse($combine['date'])->format('d-M-Y').'</td>
                    <td>'.$combine['total_bill_amount'].'</td>
                    <td>'.$combine['paid_amount'].'</td>
                    <td>'.$combine['balance'].'</td>
                    <td>'.$combine['pay_method'].'</td>
                </tr>';
            }
        }
        $output.='</tbody></table>
        <hr>
        <div class="ml-4 ">
            <div class="d-flex">
                <button class="btn btn-primary btn-xs mt--2 ml-4" id="addcat" data-toggle="modal" data-target="#chequeclearancemodal">View Detail</button>
            </div>
            <h5 class="mb-2"><strong>Total Receiveables : &nbsp; <small class="p-5">'.$total_bill_amount.'</small><strong></h5>
            <h5 class="mb-2"><strong>Total Received &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;: &nbsp; <small class="p-5">'.$total_paid_amount.'</small><strong></h5>
            <h5 ><strong>Net Receiveables &nbsp;&nbsp;&nbsp;: &nbsp; <small class="p-5">'.$total_balance.'</small><strong></h5>
        </div>
        <br>
        <button class="btn btn-success btn-sm float-right"><i class="fa fa-print"></i>&nbsp;Preview</button>  ';
        echo $output;
    }
    public function singledatecombineaccount(Request $request)
    {
      $total_bill_amount=0;
      $total_paid_amount=0;
      $total_balance=0;
      $output='
      <table id="single_combine" class="display table-sm table-striped table-hover example" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Total Bill Amount</th>
                    <th>Paid amount</th>
                    <th>Balance</th>
                    <th>Paymant Method</th>
                </tr>
            </thead>
        <tbody>';
        $dtp_from=$request->from;
        $dtp_to=$request->to;
        $cust_id=$request->cust_id;
        session()->forget('combine');
        $cust_acc=DB::table('customer_accounts')
        ->select('id','cust_invoice_no', 'total_bill_amount','balance', 'paid_amount', 'created_at', 'payment_method')
        ->whereDate('created_at','>=',$dtp_from)
        ->whereDate('created_at','<=',$dtp_to)
        ->where('cust_id','=',$cust_id)
        ->get();
        $supp_acc=DB::table('supplier_accounts')
        ->select('id','supp_invoice_no', 'total_bill_amount','balance', 'paid_amount', 'created_at', 'payment_method')
        ->whereDate('created_at','>=',$dtp_from)
        ->whereDate('created_at','<=',$dtp_to)
        ->where('supp_id','=',function($query) use($cust_id){
            $query->from('customers')
            ->select('supp_id')
            ->where('id','=',$cust_id);
        })
        ->get();
        $cart = session()->get('combine', []);
        foreach($cust_acc as $key=>$cust_data)
        {
            $cart[]= [
                "invoice" => $cust_data->cust_invoice_no,
                "total_bill_amount" => $cust_data->total_bill_amount,
                "paid_amount" => $cust_data->paid_amount,
                "date" => $cust_data->created_at,
                "balance" => $cust_data->balance,
                "pay_method" => $cust_data->payment_method,
            ];
            session()->put('combine', $cart);
        }
        foreach($supp_acc as $key=>$supp_data)
        {
            $cart[]= [
                "invoice" => $supp_data->supp_invoice_no,
                "total_bill_amount" => $supp_data->total_bill_amount,
                "paid_amount" => $supp_data->paid_amount,
                "date" => $supp_data->created_at,
                "balance" => $supp_data->balance,
                "pay_method" => $supp_data->payment_method,
            ];
            session()->put('combine', $cart);
        }
        $cartdata = session()->get('combine');
        if($cartdata)
        {
            foreach($cartdata as $key=>$combine)
            {
                $total_bill_amount+=$combine['total_bill_amount'];
                $total_paid_amount+=$combine['paid_amount'];
                $total_balance+=$combine['balance'];
                $output .='
                <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$combine['invoice'].'</td>
                    <td>'.Carbon::parse($combine['date'])->format('d-M-Y').'</td>
                    <td>'.$combine['total_bill_amount'].'</td>
                    <td>'.$combine['paid_amount'].'</td>
                    <td>'.$combine['balance'].'</td>
                    <td>'.$combine['pay_method'].'</td>
                </tr>';
            }
        }
        $output.='</tbody></table>
        <hr>
        <div class="ml-4 ">
            <h5 class="mb-2"><strong>Total Receiveables : &nbsp; <small class="p-5">'.$total_bill_amount.'</small><strong></h5>
            <h5 class="mb-2"><strong>Total Received &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;: &nbsp; <small class="p-5">'.$total_paid_amount.'</small><strong></h5>
            <h5 ><strong>Net Receiveables &nbsp;&nbsp;&nbsp;: &nbsp; <small class="p-5">'.$total_balance.'</small><strong></h5>
        </div>
        <br>
        <button class="btn btn-success btn-sm float-right"><i class="fa fa-print"></i>&nbsp;Preview</button>  ';
        echo $output;
    }
    public function loadcombine(){
        $combine=Customer::select('id','cust_name')
        ->where('status','=','Y')
        ->whereNotNull('supp_id')
        ->get();
        return response()->json($combine);
    }
}
