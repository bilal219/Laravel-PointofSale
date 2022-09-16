<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeAccount;
use App\Models\Employee;
use App\Models\CashFlow;
use App\Models\InvoiceNo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class EmployeeraccountController extends Controller
{
    public function empaccount(Request $request)
    {
        $mytime='';
        $mytime1='';
        $mytime = Carbon::now()->format('Y-m-d');
        $from = $request->input('d1');
        $to = $request->input('d2');
        if ($to=='') {
            $mytime1 = Carbon::now()->format('Y-m-d');
        
        }
        else {
            $mytime1 = $to;
        }

        if ($from=='') {
            $mytime = Carbon::now()->format('Y-m-d');
        
        }
        else {
            $mytime = $from;
        }
        $employee = Employee::where('status','=','Y')->get();
        return view('empaccounts.empaccount',compact('employee','mytime','mytime1'));
    }
    //add Payment
    public function addpayment(Request $request)
    {
        $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->empp_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->empp_acc_invoice_no=$add_inv->empp_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('empp_acc_invoice_no')->first();
        $invoice_no="EP-".$inv_no->empp_acc_invoice_no;
        
        //add payment
        $payment=new EmployeeAccount;
        $payment->emp_id=$request->emp_id;
        $payment->user_id=Auth::user()->id;
        $payment->emp_earning=$request->emp_earning;
        $payment->emp_invoice_no=$invoice_no;
        $payment->emp_withdraw_amount=0;
        $payment->balance=$request->emp_earning-0;
        $payment->note=$request->note;
        $payment->emp_acc_date=$request->emp_acc_date;
        $payment->processed_by=$request->addedby;
        $payment->save();
       return response()->json([
        'status'=>200
    ]);
    }
    //fetch Payment
    public function fetchemppayment(Request $request)
    {
        $total_earnings=0;
        $total_withdraw=0;
        $total_balance=0;
        $employee= $request->employee;
        $from = $request->from;
        $to = $request->to;
        $pre_balance=0;

        $emp=DB::table('employee_accounts')
        ->join('employees','employees.id','=','employee_accounts.emp_id')
        ->whereDate('employee_accounts.emp_acc_date', '>=', $from)
        ->whereDate('employee_accounts.emp_acc_date', '<=', $to)
        ->where('employee_accounts.emp_id',$employee)
        ->select('employee_accounts.*','employees.emp_name')
        ->get();
        $emp_data ='<table id="add-row" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Date</th>
                    <th>Total Earnings</th>
                    <th>Total WithDraw</th>
                    <th>Balance</th>
                    <th>Prev Balance</th>
                    <th>Total</th>
                </tr>
            </thead>
        <tbody>';
        $balance=0;   
        if ($emp->count()>0)
        {
            foreach($emp as $key=>$list)
            {
                $cust_acc=EmployeeAccount::
                where('emp_id','=',$list->emp_id)
                ->where('id','<',$list->id)
                ->sum('balance');
                $balance = $list->emp_earning - $list->emp_withdraw_amount;
                $total_balance+=$balance;
                $total_earnings+=$list->emp_earning;
                $total_withdraw+=$list->emp_withdraw_amount;
                $sr=$key+1;
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $emp_data .='<tr>
                <td>'.$sr.'</td>
                <td>'.date('d-m-Y', strtotime($list->emp_acc_date)).'</td>
                <td>'.$list->emp_earning.'</td>
                <td>'.$list->emp_withdraw_amount.'</td>
                <td>'.$balance.'</td>
                <td>'.$pre_balance.'</td>
                <td>'.($list->balance+$pre_balance).'</td>
                </tr>';
            }
        }
        $emp_data.='</tbody></table>
        <hr>
            <div class="ml-4 ">
                <h5 class="mb-2"><strong>Total Earnings  &nbsp; <small class="p-5">'.$total_earnings.'</small><strong></h5>
                <h5 class="mb-2"><strong>Total Withdraw &nbsp;&nbsp;&nbsp;&nbsp; &nbsp; <small class="p-4">'.$total_withdraw.'</small><strong></h5>
                <h5 ><strong>Net Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <small class="p-5">'.$total_balance.'</small><strong></h5>
            </div>
        <br>
        <button class="btn btn-success btn-sm float-right"><i class="fa fa-print"></i>&nbsp;Preview</button>';
        echo $emp_data;    
    }
        //withdraw Payment
        public function withdrawpayment(Request $request)
        {
            $count=InvoiceNo::count();
        if($count==0)
        { 
         $add_inv=new InvoiceNo;
         $add_inv->empp_acc_invoice_no=1;
         $add_inv->save();
        }else if($count==1)
        {
         $add_inv=InvoiceNo::find(1);
         $add_inv->empp_acc_invoice_no=$add_inv->empp_acc_invoice_no+1;
         $add_inv->update();
        }
        $inv_no=InvoiceNo::select('empp_acc_invoice_no')->first();
        $invoice_no="WD-".$inv_no->empp_acc_invoice_no;
        //add payment
        $payment=new EmployeeAccount;
        $payment->emp_id=$request->emp_id;
        $payment->user_id=Auth::user()->id;
        $payment->emp_earning=0;
        $payment->emp_invoice_no=$invoice_no;
        $payment->emp_withdraw_amount=$request->emp_withdraw_amount;
        $payment->balance=0-$request->emp_withdraw_amount;
        $payment->note=$request->note;
        $payment->emp_acc_date=$request->emp_acc_date;
        $payment->processed_by=$request->addedby;
        $payment->save();
       return response()->json([
        'status'=>200
        ]);

    }
}
