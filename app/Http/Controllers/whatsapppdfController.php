<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CustomerAccount;
use App\Models\ChequeInfo;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client ;
use DB;
use GuzzleHttp;
use Carbon\Carbon;
class whatsapppdfController extends Controller
{
    //
    public function whatsappcustaccount(Request $request)
    {
        $from=$request->from;
        $to=$request->to;
        $output='';
        
        if(!$from && !$to)
        {
            $total_bill_amount=0;
            $total_paid_amount=0;
            $total_balance=0;
            $chq_total=0;
            $pre_balance=0;
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
            $output ='<div class="table-responsive" id="rpt_body">
            <table id="fetch-customer-accounts" class="display table-sm table-striped table-hover example" style="width:100%">
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
            $output .='</tbody></table></div>
            </hr>
            <div id="rpt_footer" class="my-4 d-flex">
                <div class="ml-4 ">
                    <h5 class="mb-2"><strong>No of Unpaid Cheques : &nbsp; <small class="p-4">'.$no_of_chqs.'</small><strong></h5>
                    <div class="d-flex">
                        <h5 class="mb-2"><strong>Unpaid Cheques Amount : &nbsp;&nbsp;&nbsp; <small>'.$chq_total.'</small><strong></h5>
                    </div>
                    <h5 class="mb-2"><strong>Total Receiveables : &nbsp; <small class="p-5">'.$total_bill_amount.'</small><strong></h5>
                    <h5 class="mb-2"><strong>Total Received &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <small class="p-5">'.$total_paid_amount.'</small><strong></h5>
                    <h5 ><strong>Net Receiveables &nbsp;&nbsp;&nbsp;: &nbsp; <small class="p-5">'.$total_balance.'</small><strong></h5>
                </div>
                <br>
            </div>';
        }

        $pdf = Pdf::loadHTML('<div class="modal-content">   
        <div class="modal-body" id="printreport">
            <center class="mt-3">
                <h3><strong>Technic Mentors</strong></h3>
                <h5>Mumtaz Market Gujranwala</h4>
            </center>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="panel panel-default">
                        <div class="panel-heading d-flex">
                            <center><h3 class="panel-title mx-auto"><strong><u id="rpt_name">Report Name</u></strong></h3></center>
                        </div>
                        <div class="d-flex">
                            <p ><strong id="rpt_param"></strong></p>
                            <p class="ml-auto">
                                <strong id="rpt_from" class="mx-3"></strong>
                                <strong id="rpt_to" class="mx-3"></strong>
                            </p>
                        </div>
                        <div class="panel-body mt--3">
                            '.$output.'
                        </div>
                        <div class="col-md-6 ml-auto mr-auto text-center mb-4" id="bus_msg">                                    
                        </div>
                        <footer style="bottom:20%">
                            <center>
                                <strong> Software Developed </strong><small>with love by</small><strong>Technic Mentors</strong>&nbsp;|&nbsp; 0300-4900046
                            </center>
                        </footer>
                    </div>
                </div>
            </div>
        </div>      
    </div>');
    $filename=$request->customer_id.'_account'.time().'.pdf';
        Storage::put("public/custaccountpdf/$filename",$pdf->output());

      //sms send
      try{
          //code... paid api is necessary
            $to='whatsapp:+923318769683';
            $account_sid = env('TWILIO_SID');
            $account_token = env('TWILIO_TOKEN');
            $number = 'whatsapp:+14155238886';
            $client = new Client($account_sid,$account_token);
            $client->messages->create($to,[
                'from' =>$number,
                'body' =>"Hi.How are you ?"
            ]);
      } catch (\Exception $th) {
        return $th->getMessage();
      }
    
        return response()->json(['status'=>200,$output]);
    }
    //
    
    public function singlecustwhatsappaccount(Request $request)
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
}
