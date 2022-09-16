<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierAccount;
use App\Models\CashFlow;
use App\Models\InvoiceNo;
use App\Models\ChequeInfo;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
class SupplieraccountController extends Controller
{
    public function supplieraccount()
    {
        return view('supplieraccount.account');
    }
    public function supplieraddpayview()
    {
        return view('supplieraccount.addpayment');
    }
    public function addsuppcashpayment(Request $request)
    {
        $name=Supplier::select('supp_name')->find($request->supplier);
        $prev_balance=DB::table('supplier_accounts')
        ->select('id')
        ->where('supp_id','=',$request->supplier)       
        ->sum('balance');
        $type="Received In Company";
        if($request->pay_type=="paid_by_company")
        {
            $type="Paid by Company";
        }
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->supp_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->supp_acc_invoice_no=$add_inv->supp_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('supp_acc_invoice_no')->first();
        $invoice_no="SP-".$inv_no->supp_acc_invoice_no;
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        if($request->pay_type=="received_in_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        else if($request->pay_type=="paid_by_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        $supp_account=new SupplierAccount();
        $supp_account->total_bill_amount=$total_bill;
        $supp_account->paid_amount=$paid_amount;
        $supp_account->supp_invoice_no=$invoice_no;
        $supp_account->supp_id=$request->supplier;
        $supp_account->payment_method="By Cash";
        $supp_account->payment_type=$request->pay_type;
        $supp_account->supp_acc_date=$request->supp_acc_date;
        $supp_account->balance=$balance;
        //cashflow
        $cash_flow=new CashFlow();
        $cash_flow->party=$request->supplier;
        $cash_flow->cash_in=$paid_amount;
        $cash_flow->cash_out=$total_bill;
        $cash_flow->balance=$balance;
        $cash_flow->cf_date=$request->supp_acc_date;
        $supp_account->save();
        $cash_flow->save();
        $content=
        '<div class="col-md-12 mt-4">
            <div class="panel panel-default">
                <div class="panel-heading d-flex">
                    <h3 class="panel-title mx-auto"><strong><u id="rpt_name">Supplier Payment</u></strong></h3>
                </div>
                <div class="col-lg mb-4">
                    <table class="table-sm table-condensed mx-auto">
                        <tbody>
                            <tr>
                                <td><b>Date :</b></td>
                                <td class="text-right pl-4">'.Carbon::parse($request->supp_acc_date)->format('d-M-Y').'</td>
                            </tr>
                            <tr>
                                <td><b>Supplier Name :</b></td>
                                <td class="text-right pl-4">'.$name->supp_name.'</td>
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
    public function addsuppchqpayment(Request $request)
    {

        $name=Supplier::select('supp_name')->find($request->supplier);
        $prev_balance=DB::table('supplier_accounts')
        ->select('id')
        ->where('supp_id','=',$request->supplier)       
        ->sum('balance');
        $type="Received In Company";
        if($request->pay_type=="paid_by_company")
        {
            $type="Paid by Company";
        }

        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->supp_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->supp_acc_invoice_no=$add_inv->supp_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('supp_acc_invoice_no')->first();
        $invoice_no="CHP-".$inv_no->supp_acc_invoice_no;
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        if($request->pay_type=="paid_by_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        else if($request->pay_type=="received_in_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        $chq_info=new ChequeInfo();
        $chq_info->supp_id=$request->supplier;
        $chq_info->user_id=Auth::user()->id;
        $chq_info->chq_number=$request->chq_number;
        $chq_info->chq_amount=$request->amount;
        $chq_info->status='Due';
        $chq_info->note=$request->note;
        $chq_info->chq_date=$request->supp_chq_date;
        $chq_info->payment_method=$request->pay_type;
        //cashflow
        $cash_flow=new CashFlow();
        $cash_flow->party=$request->supplier;
        $cash_flow->cash_in=$paid_amount;
        $cash_flow->cash_out=$total_bill;
        $cash_flow->balance=$balance;
        $cash_flow->cf_date=$request->supp_chq_date;
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
                                <td class="text-right pl-4">'.Carbon::parse($request->supp_chq_date)->format('d-M-Y').'</td>
                            </tr>
                            <tr>
                                <td><b>Cheque Number :</b></td>
                                <td class="text-right pl-4">'.$request->chq_number.'</td>
                            </tr>
                            <tr>
                                <td><b>Customer Name :</b></td>
                                <td class="text-right pl-4">'.$name->supp_name.'</td>
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
    public function singlesupplieraccount(Request $request)
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $chq_total=0;
        $pre_balance=0;
        //count the unpaid cheques
        $no_of_chqs=DB::table('cheque_infos')
        ->where('supp_id','=',$request->supplier_id)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('supp_id','=',$request->supplier_id)
        ->where('status','=','Due')
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }
        //single customer   
        $cust=SupplierAccount::where('supp_id','=',$request->supplier_id)
        ->orderBy('id','asc')->get();
       
            $output .='<table id="fetch-supplier-accounts" class="display table-sm table-striped table-hover example" style="width:100%">
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
                    $cust_acc=SupplierAccount::
                    where('supp_id','=',$custdata->supp_id)
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
                    <td>'.$custdata->supp_invoice_no.'</td>
                    <td>'.Carbon::parse($custdata->supp_acc_date)->format('d-M-Y').'</td>
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
            <button class="btn btn-success btn-sm float-right" id="button"><i class="fa fa-print"></i>&nbsp;Preview</button>  ';
        echo $output;
    }
    public function allsupplieraccount()
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $supp=DB::table('supplier_accounts')
        ->select('suppliers.supp_name', DB::raw("SUM(supplier_accounts.total_bill_amount) as total_bill_amount"), DB::raw("SUM(supplier_accounts.paid_amount) as paid_amount"), DB::raw("SUM(supplier_accounts.balance) as balance"))
        ->join('suppliers','suppliers.id','=','supplier_accounts.supp_id')
        ->groupBy('suppliers.supp_name')
        ->get();
        $output .='<table id="fetch-all-supplier-accounts" class="display table-sm table-striped table-hover" style="width:100%">
        <thead>
            <tr>
            <th>Sr#</th>
            <th>Supplier name</th>
            <th>Total Bill Amount</th>
            <th>Paid amount</th>
            <th>Balance</th>
            </tr>
        </thead>
        <tbody>';
        if($supp->count()>0)
        {
            foreach($supp as $key=> $suppdata)
            {   $sr=$key+1;
                $total_bill_amount+=$suppdata->total_bill_amount;
                $total_paid_amount+=$suppdata->paid_amount;
                $total_balance+=$suppdata->balance;
                $output .='<tr>
                <td>'.$sr.'</td>
                <td>'.$suppdata->supp_name.'</td>
                <td>'.$suppdata->total_bill_amount.'</td>
                <td>'.$suppdata->paid_amount.'</td>
                <td>'.$suppdata->balance.'</td>
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
    public function singledatesupplieraccount(Request $request)
    {
        $output='';
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $chq_total=0;
        $pre_balance=0;
        //count the unpaid cheques
        $no_of_chqs=DB::table('cheque_infos')
        ->where('supp_id','=',$request->supplier_id)
        ->wheredate('chq_date','>=',$request->dtp_from)
        ->wheredate('chq_date','<=',$request->dtp_to)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('supp_id','=',$request->supplier_id)
        ->where('status','=','Due')
        ->wheredate('chq_date','>=',$request->dtp_from)
        ->wheredate('chq_date','<=',$request->dtp_to)
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }
        //single customer   
        $cust=SupplierAccount::where('supp_id','=',$request->supplier_id)
        ->wheredate('supp_acc_date','>=',$request->dtp_from)
        ->wheredate('supp_acc_date','<=',$request->dtp_to)
        ->orderBy('id','asc')->get();
        $output .='<table id="fetch-supplier-accounts" class="display table-sm table-striped table-hover example" style="width:100%">
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
                $cust_acc=SupplierAccount::
                    where('supp_id','=',$custdata->supp_id)
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
                <td>'.$custdata->supp_invoice_no.'</td>
                <td>'.Carbon::parse($custdata->supp_acc_date)->format('d-M-Y').'</td>
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
    public function suppchqclearanceview()
    {
        return view('supplieraccount.chequeclearance');
    }
    //fetch cheque info
    public function fetchsuppchequeinfo(Request $request)
    {
        $output='';
        $supp_id=$request->supp_id;
        $chque_info=DB::table('cheque_infos')
        ->select('suppliers.supp_name','cheque_infos.supp_id', 'cheque_infos.id','cheque_infos.chq_number', 'cheque_infos.chq_amount', 'cheque_infos.status', 'cheque_infos.payment_method', 'cheque_infos.chq_date')
        ->join('suppliers','cheque_infos.supp_id','=','suppliers.id')
        ->where('cheque_infos.status','=','Due')
        ->where('cheque_infos.supp_id','=',$supp_id)
        ->get();
        $output .='<table id="fetch_supplier_cheques" class="display table-sm table-striped table-hover example" style="width:100%">
        <thead>
            <tr>
                <th>Sr #</th>
                <th>Supplier</th>
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
                <td id="'.$custdata->supp_id.'">'.$custdata->supp_name.'</td>
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
    public function clearsuppcheque(Request $request)
    {
        $paid_amount=0;
        $total_bill=0;
        $balance=0;
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->supp_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->supp_acc_invoice_no=$add_inv->supp_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('supp_acc_invoice_no')->first();
        $invoice_no="SCH-".$inv_no->supp_acc_invoice_no;
        //update cheque
        $id=$request->info_id;
        $cheque_Info=ChequeInfo::find($id);
        $cheque_Info->status='Cleared';
        $cheque_Info->clear_date=$request->supp_clear_date;
        $cheque_Info->clear_note=$request->clear_note;
        //add to customer account
        if($request->pay_type=="paid_by_company")
        {$paid_amount=$request->amount;
         $balance=0-$request->amount;
        }
        else if($request->pay_type=="received_in_company")
        {$total_bill=$request->amount;
         $balance=$request->amount;
        }
        $cust_account=new SupplierAccount();
        $cust_account->total_bill_amount=$total_bill;
        $cust_account->paid_amount=$paid_amount;
        $cust_account->supp_invoice_no=$invoice_no;
        $cust_account->supp_id=$request->supp_id;
        $cust_account->payment_method="By Cheque";
        $cust_account->payment_type=$request->pay_type;
        $cust_account->supp_acc_date=$cheque_Info->chq_date;
        $cust_account->balance=$balance;
        $cheque_Info->save();
        $cust_account->save();
        return response()->json([
            'status'=>200
        ]);
       
    }
    public function receivables()
    {
        return view('supplieraccount.allreceivables');
    }
}
