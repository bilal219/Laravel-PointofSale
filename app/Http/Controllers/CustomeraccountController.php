<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerAccount;
use App\Models\CashFlow;
use App\Models\InvoiceNo;
use App\Models\ChequeInfo;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
class CustomeraccountController extends Controller
{
    public function customeraccount()
    {
        return view('customeraccount.account');
    }
    public function customeraddpayview()
    {
        return view('customeraccount.addpayment');
    }
    public function addcashpayment(Request $request)
    {
        // report calculation
        $name=Customer::select('cust_name')->find($request->customer);
        $prev_balance=DB::table('customer_accounts')
        ->select('id')
        ->where('cust_id','=',$request->customer)       
        ->sum('balance');
        $type="Received In Company";
        if($request->pay_type=="paid_by_company")
        {
            $type="Paid by Company";
        }
        //addpaymrnt code
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->cust_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->cust_acc_invoice_no=$add_inv->cust_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('cust_acc_invoice_no')->first();
        $invoice_no="CP-".$inv_no->cust_acc_invoice_no;
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        if($request->pay_type=="received_in_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        else if($request->pay_type=="paid_by_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        $cust_account=new CustomerAccount();
        $cust_account->total_bill_amount=$total_bill;
        $cust_account->paid_amount=$paid_amount;
        $cust_account->cust_invoice_no=$invoice_no;
        $cust_account->cust_id=$request->customer;
        $cust_account->payment_method="By Cash";
        $cust_account->payment_type=$request->pay_type;
        $cust_account->cust_acc_date=$request->cust_acc_date;
        $cust_account->balance=$balance;
        //cashflow
        $cash_flow=new CashFlow();
        $cash_flow->party=$request->customer;
        $cash_flow->cash_in=$paid_amount;
        $cash_flow->cash_out=$total_bill;
        $cash_flow->balance=$balance;
        $cash_flow->cf_date=$request->cust_acc_date;
        $cust_account->save();
        $cash_flow->save();

        $content='<div class="col-md-12 mt-4">
        <div class="panel panel-default">
            <div class="panel-heading d-flex">
                <h3 class="panel-title mx-auto"><strong><u id="rpt_name">Customer Payment</u></strong></h3>
            </div>
            <div class="col-lg mb-4">
                <table class="table-sm table-condensed mx-auto">
                    <tbody>
                        <tr>
                            <td><b>Date :</b></td>
                            <td class="text-right pl-4">'.Carbon::parse($request->cust_acc_date)->format('d-M-Y').'</td>
                        </tr>
                        <tr>
                            <td><b>Customer Name :</b></td>
                            <td class="text-right pl-4">'.$name->cust_name.'</td>
                        </tr>
                        <tr>
                            <td><b>Payment :</b></td>
                            <td class="text-right pl-4">'.$request->amount.'</td>
                        </tr>
                        <tr>
                            <td><b>Previous Balance :</b></td>
                            <td class="text-right pl-4">'.$prev_balance.'</td>
                        </tr>
                        <tr>
                            <td><b>Nat Balance :</b></td>
                            <td class="text-right pl-4">'.$prev_balance+$balance.'</td>
                        </tr>
                        <tr>
                            <td><b>Payment Type :</b></td>
                            <td class="text-right pl-4">'.$type.'</td>
                        </tr>
                        <tr>
                            <td><b>Payment Method :</b></td>
                            <td class="text-right pl-4">By Cash</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <footer style="bottom:0;height:100%">
                <center>
                    <strong> Software Developed </strong><small>with love by</small><strong>Technic Mentors</strong>&nbsp;|&nbsp; 0300-4900046
                </center>
            </footer>
        </div>
    </div>';
        return response()->json(['status'=>200,'content'=>$content]);  
    }
    //cheque payment
    public function addchqpayment(Request $request)
    {
        $name=Customer::select('cust_name')->find($request->customer);
        $prev_balance=DB::table('customer_accounts')
        ->select('id')
        ->where('cust_id','=',$request->customer)       
        ->sum('balance');
        $type="Received In Company";
        if($request->pay_type=="paid_by_company")
        {
            $type="Paid by Company";
        }
        
        //
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->cust_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->cust_acc_invoice_no=$add_inv->cust_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('cust_acc_invoice_no')->first();
        $invoice_no="CHP-".$inv_no->cust_acc_invoice_no;
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        if($request->pay_type=="received_in_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        else if($request->pay_type=="paid_by_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        $chq_info=new ChequeInfo();
        $chq_info->cust_id=$request->customer;
        $chq_info->user_id=Auth::user()->id;
        $chq_info->chq_number=$request->chq_number;
        $chq_info->chq_amount=$request->amount;
        $chq_info->status='Due';
        $chq_info->note=$request->note;
        $chq_info->chq_date=$request->chq_date;
        $chq_info->payment_method=$request->pay_type;
        //cashflow
        $cash_flow=new CashFlow();
        $cash_flow->party=$request->customer;
        $cash_flow->cash_in=$paid_amount;
        $cash_flow->cash_out=$total_bill;
        $cash_flow->balance=$balance;
        $cash_flow->cf_date=$request->chq_date;
        $chq_info->save();
        $cash_flow->save();

        $content='<div class="col-md-12 mt-4">
            <div class="panel panel-default">
                <div class="panel-heading d-flex">
                    <h3 class="panel-title mx-auto"><strong><u id="rpt_name">Customer Payment</u></strong></h3>
                </div>
                <div class="col-lg mb-4">
                    <table class="table-sm table-condensed mx-auto">
                        <tbody>
                            <tr>
                                <td><b>Date :</b></td>
                                <td class="text-right pl-4">'.Carbon::parse($request->chq_date)->format('d-M-Y').'</td>
                            </tr>
                            <tr>
                                <td><b>Cheque Number :</b></td>
                                <td class="text-right pl-4">'.$request->chq_number.'</td>
                            </tr>
                            <tr>
                                <td><b>Customer Name :</b></td>
                                <td class="text-right pl-4">'.$name->cust_name.'</td>
                            </tr>
                            <tr>
                                <td><b>Payment :</b></td>
                                <td class="text-right pl-4">'.$request->amount.'</td>
                            </tr>
                            <tr>
                                <td><b>Previous Balance :</b></td>
                                <td class="text-right pl-4">'.$prev_balance.'</td>
                            </tr>
                            <tr>
                                <td><b>Check Status :</b></td>
                                <td class="text-right pl-4">Unpaid</td>
                            </tr>
                            <tr>
                                <td><b>Payment Type :</b></td>
                                <td class="text-right pl-4">'.$type.'</td>
                            </tr>
                            <tr>
                                <td><b>Payment Method :</b></td>
                                <td class="text-right pl-4">By Cheque</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <footer style="bottom:0;height:100%">
                    <center>
                        <strong> Software Developed </strong><small>with love by</small><strong>Technic Mentors</strong>&nbsp;|&nbsp; 0300-4900046
                    </center>
                </footer>
            </div>
        </div>';
        return response()->json(['status'=>200,'content'=>$content]);  
    }
    //fetch accounts data 
    public function singlecustomeraccount(Request $request)
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $chq_total=0;
        $pre_balance=0;
        $btn='';
        //count the unpaid cheques
        $no_of_chqs=DB::table('cheque_infos')
        ->where('cust_id','=',$request->customer_id)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('cust_id','=',$request->customer_id)
        ->where('status','=','Due')
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }
        //single customer   
        $cust=CustomerAccount::where('cust_id','=',$request->customer_id)
        ->orderBy('id','asc')->get();
        // if($cust->count()>0){
        //     $btn='<button class="btn btn-xs btn-success btncustwhatsapp mr-2" id="'.$request->customer_id.'"><i class="fab fa-whatsapp"></i>&nbsp;Send To Whatsapp</button></br></br>';
        // }
        $output .=''.$btn.'<table id="fetch-customer-accounts" class="display table-sm table-striped table-hover example" style="width:100%">
        <thead>
            <tr>
            <th>Sr#</th>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Total Bill Amount</th>
            <th>Paid amount</th>
            <th>Balance</th>
            <th>Pre Balance</th>
            <th>Total</th>
            <th>Paymant Type</th>
            <th>Paymant Method</th>
            </tr>
        </thead>
        <tbody>';
        if($cust->count()>0)
        {
            foreach($cust as $key=> $custdata)
            { 
                $cust_acc=CustomerAccount::where('cust_id','=',$custdata->cust_id)
                ->where('id','<',$custdata->id)
                ->sum('balance');
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $type="Received In Company";
                if($custdata->payment_type=="paid_by_company")
                {
                    $type="Paid by Company";
                }
                $total_bill_amount+=$custdata->total_bill_amount;
                $total_paid_amount+=$custdata->paid_amount;
                $total_balance+=$custdata->balance;
                $output .='<tr>
                <td>'.($key+1).'</td>
                <td>'.$custdata->cust_invoice_no.'</td>
                <td>'.Carbon::parse($custdata->cust_acc_date)->format('d-M-Y').'</td>
                <td>'.$custdata->total_bill_amount.'</td>
                <td>'.$custdata->paid_amount.'</td>
                <td>'.$custdata->balance.'</td>
                <td>'.$pre_balance.'</td>
                <td>'.($custdata->balance+$pre_balance).'</td>
                <td>'.$type.'</td>
                <td>'.$custdata->payment_method.'</td>
                </tr>';
            }
        }
        $output .='</tbody></table>
        <hr>
        <div class="ml-4 ">
            <h5 class="mb-2"><strong>No of Unpaid Cheques : &nbsp; <small class="p-4">'.$no_of_chqs.'</small><strong></h5>
            <div class="d-flex">
                <h5 class="mb-2"><strong>Unpaid Cheques Amount : &nbsp;&nbsp;&nbsp; <small>'.$chq_total.'</small><strong></h5>
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
    public function allcustomeraccount()
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $cust=DB::table('customer_accounts')
        ->select('customers.cust_name', DB::raw("SUM(customer_accounts.total_bill_amount) as total_bill_amount"), DB::raw("SUM(customer_accounts.paid_amount) as paid_amount"), DB::raw("SUM(customer_accounts.balance) as balance"))
        ->join('customers','customers.id','=','customer_accounts.cust_id')
        ->groupBy('customers.cust_name')
        ->get();
        $output .='<table id="fetch-all-customer-accounts" class="display table-sm table-striped table-hover" style="width:100%">
        <thead>
            <tr>
            <th>Sr#</th>
            <th>Customer name</th>
            <th>Total Bill Amount</th>
            <th>Paid amount</th>
            <th>Balance</th>
            </tr>
        </thead>
        <tbody>';
        if($cust->count()>0)
        {
            foreach($cust as $key=> $custdata)
            {   $sr=$key+1;
                $total_bill_amount+=$custdata->total_bill_amount;
                $total_paid_amount+=$custdata->paid_amount;
                $total_balance+=$custdata->balance;
                $output .='<tr>
                <td>'.$sr.'</td>
                <td>'.$custdata->cust_name.'</td>
                <td>'.$custdata->total_bill_amount.'</td>
                <td>'.$custdata->paid_amount.'</td>
                <td>'.$custdata->balance.'</td>
                </tr>';
            }
        }
        $output .='</tbody>
        </table>
        <hr>
        <h5 class="mb-2"><strong>Total Receiveables : &nbsp; <small>'.$total_bill_amount.'</small><strong></h5>
        <h5 class="mb-2"><strong>Total Received &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;: &nbsp; <small>'.$total_paid_amount.'</small><strong></h5>
        <h5 ><strong>Net Receiveables &nbsp;&nbsp;&nbsp;: &nbsp; <small>'.$total_balance.'</small><strong></h5>
        ';
        echo $output;
    }
    public function singledatecustomeraccount(Request $request)
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $chq_total=0;
        $pre_balance=0;
        //count the unpaid cheques
        $no_of_chqs=DB::table('cheque_infos')
        ->where('cust_id','=',$request->customer_id)
        ->wheredate('chq_date','>=',$request->dtp_from)
        ->wheredate('chq_date','<=',$request->dtp_to)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('cust_id','=',$request->customer_id)
        ->where('status','=','Due')
        ->wheredate('chq_date','>=',$request->dtp_from)
        ->wheredate('chq_date','<=',$request->dtp_to)
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }
        //single customer   
        $cust=CustomerAccount::where('cust_id','=',$request->customer_id)
        ->wheredate('cust_acc_date','>=',$request->dtp_from)
        ->wheredate('cust_acc_date','<=',$request->dtp_to)
        ->orderBy('id','asc')->get();
        $output .='<table id="fetch-customer-accounts" class="display table-sm table-striped table-hover example" style="width:100%">
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Total Bill Amount</th>
                <th>Paid amount</th>
                <th>Balance</th>
                <th>Pre Balance</th>
                <th>Total</th>
                <th>Payment Type</th>
                <th>Paymant Method</th>
            </tr>
        </thead>
        <tbody>';
        if($cust->count()>0)
        {

            foreach($cust as $key=> $custdata)
            { 
                $cust_acc=CustomerAccount::
                where('cust_id','=',$custdata->cust_id)
                ->where('id','<',$custdata->id)
                ->sum('balance');
                $type="Received In Company";
                if($custdata->payment_type=="paid_by_company")
                {
                    $type="Paid by Company";
                }
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $total_bill_amount+=$custdata->total_bill_amount;
                $total_paid_amount+=$custdata->paid_amount;
                $total_balance+=$custdata->balance;
                $output .='<tr>
                <td>'.($key+1).'</td>
                <td>'.$custdata->cust_invoice_no.'</td>
                <td>'.Carbon::parse($custdata->cust_acc_date)->format('d-M-Y').'</td>
                <td>'.$custdata->total_bill_amount.'</td>
                <td>'.$custdata->paid_amount.'</td>
                <td>'.$custdata->balance.'</td>
                <td>'.$pre_balance.'</td>
                <td>'.($custdata->balance+$pre_balance).'</td>
                <td>'.$type.'</td>
                <td>'.$custdata->payment_method.'</td>
                </tr>';
            }
        }
        $output .='</tbody></table>
        <hr>
        <div class="ml-4 ">
            <h5 class="mb-2"><strong>No of Unpaid Cheques : &nbsp; <small class="p-4">'.$no_of_chqs.'</small><strong></h5>
            <div class="d-flex">
                <h5 class="mb-2"><strong>Unpaid Cheques Amount : &nbsp;&nbsp;&nbsp; <small>'.$chq_total.'</small><strong></h5>
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
    // cheque clearance view 
    public function chqclearanceview()
    {
        return view('customeraccount.chequeclearance');
    }
    //fetch cheque info
    public function fetchchequeinfo(Request $request)
    {
        $output='';
        $cust_id=$request->cust_id;
        $chque_info=DB::table('cheque_infos')
        ->select('customers.cust_name','cheque_infos.cust_id', 'cheque_infos.id','cheque_infos.chq_number', 'cheque_infos.chq_amount', 'cheque_infos.status', 'cheque_infos.payment_method', 'cheque_infos.chq_date')
        ->join('customers','cheque_infos.cust_id','=','customers.id')
        ->where('cheque_infos.status','=','Due')
        ->where('cheque_infos.cust_id','=',$cust_id)
        ->get();
        $output .='<table id="fetch_customer_cheques" class="display table-sm table-striped table-hover example" style="width:100%">
        <thead>
            <tr>
                <th>Sr #</th>
                <th>Customer</th>
                <th>Cheque Number</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Paymant Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>';
        if($chque_info->count()>0)
        {
            foreach($chque_info as $key=> $custdata)
            { 
                $sr=$key+1;
                $output .='<tr id="'.$custdata->id.'">
                <td>'.$sr.'</td>
                <td id="'.$custdata->cust_id.'">'.$custdata->cust_name.'</td>
                <td>'.$custdata->chq_number.'</td>
                <td>'.$custdata->chq_amount.'</td>
                <td>'.$custdata->status.'</td>
                <td>'.$custdata->payment_method.'</td>
                <td>'.Carbon::parse($custdata->chq_date)->format('d-M-Y').'</td>
                </tr>';
            }
        }
        $output .='</tbody></table>';
        echo $output;
    }
    //clear cheque
    public function clearcheque(Request $request)
    {
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->cust_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->cust_acc_invoice_no=$add_inv->cust_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('cust_acc_invoice_no')->first();
        $invoice_no="CHP-".$inv_no->cust_acc_invoice_no;
        //update cheque
        $id=$request->info_id;
        $cheque_Info=ChequeInfo::find($id);
        $cheque_Info->status='Cleared';
        $cheque_Info->clear_date=$request->cust_clear_date;
        $cheque_Info->clear_note=$request->clear_note;
        //add to customer account
        if($request->pay_type=="received_in_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        else if($request->pay_type=="paid_by_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        $cust_account=new CustomerAccount();
        $cust_account->total_bill_amount=$total_bill;
        $cust_account->paid_amount=$paid_amount;
        $cust_account->cust_invoice_no=$invoice_no;
        $cust_account->cust_id=$request->cust_id;
        $cust_account->payment_method="By Cheque";
        $cust_account->payment_type=$request->pay_type;
        $cust_account->cust_acc_date=$cheque_Info->chq_date;
        $cust_account->balance=$balance;
        $cheque_Info->save();
        $cust_account->save();
        return response()->json([
            'status'=>200
        ]); 
    }
}
