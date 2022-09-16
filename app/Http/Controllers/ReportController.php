<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ExpenseCategory;
use App\Models\CashRegister;
use App\Models\CustomerAccount;
use App\Models\SupplierAccount;
use App\Models\EmployeeAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
   //customer ids
    public function loadcust_id()
    {
        $dd_fst="";
        $dd_lst="";
        $fst_id=Customer::select('id')->where('status','=','Y')
        ->get();
        $lst_id=Customer::select('id')->where('status','=','Y')
        ->orderBy('id','desc')->get();
        foreach($fst_id as $fst_data)
        {
            $dd_fst.='<option value="'.$fst_data->id.'">'.$fst_data->id.'</option>';
        }
        foreach($lst_id as $lst_data)
        {
            $dd_lst.='<option value="'.$lst_data->id.'">'.$lst_data->id.'</option>';
        }
        return response()->json([
        'fst_dd'=>$dd_fst,
        'lst_dd'=>$dd_lst
        ]);

        
    }

    //supplier ids
    public function loadsupp_id()
    {
        $dd_fst="";
        $dd_lst="";
        $fst_id=Supplier::select('id')->where('status','=','Y')
        ->get();
        $lst_id=Supplier::select('id')->where('status','=','Y')
        ->orderBy('id','desc')->get();
        foreach($fst_id as $fst_data)
        {
            $dd_fst.='<option value="'.$fst_data->id.'">'.$fst_data->id.'</option>';
        }
        foreach($lst_id as $lst_data)
        {
            $dd_lst.='<option value="'.$lst_data->id.'">'.$lst_data->id.'</option>';
        }
        return response()->json([
        'fst_dd'=>$dd_fst,
        'lst_dd'=>$dd_lst
        ]);

        
    }

    //employee ids
    public function loademp_id()
    {
        $dd_fst="";
        $dd_lst="";
        $fst_id=Employee::select('id')->where('status','=','Y')
        ->get();
        $lst_id=Employee::select('id')->where('status','=','Y')
        ->orderBy('id','desc')->get();
        foreach($fst_id as $fst_data)
        {
            $dd_fst.='<option value="'.$fst_data->id.'">'.$fst_data->id.'</option>';
        }
        foreach($lst_id as $lst_data)
        {
            $dd_lst.='<option value="'.$lst_data->id.'">'.$lst_data->id.'</option>';
        }
        return response()->json([
        'fst_dd'=>$dd_fst,
        'lst_dd'=>$dd_lst
        ]);

        
    }

    // load categories for product list
    public function loadcat_id()
    {
        $dd_fst='';
        $fst_id=Category::select('id','cat_name')->where('cat_status','=','Y')
        ->get();
        foreach($fst_id as $fst_data)
        {
            $dd_fst.='<option value="'.$fst_data->id.'">'.$fst_data->cat_name.'</option>';
        }
        echo $dd_fst;  
    }
    
    // load customer ids for account
    public function loadcust_acc_id()
    {
        $dd_fst='';
        $fst_id=Customer::select('id','cust_name')
        ->where('status','=','Y')->get();
        foreach($fst_id as $fst_data)
        {
            $dd_fst.='<option value="'.$fst_data->id.'">'.$fst_data->cust_name.'</option>';
        }
        echo $dd_fst;  
    }

    //list show
    public function productlist()
    {
        return view('productreports.productlist');
    }   
    //products fetching for report
    public function fetchproducts(Request $request)
    {
        $products='';
        $cat = $request->category;
        if ($cat!=null)
        {
            $products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.cat_id')
            ->join('u_o_m_s', 'u_o_m_s.id', '=', 'products.uom_id')
            ->select('products.*', 'categories.cat_name','u_o_m_s.uom_name')
            ->where('products.cat_id',$cat)
            ->where('products.product_status','=','Y')
            ->get();    
        }
        else
        {
            $products = DB::table('products')
            ->leftjoin('categories', 'categories.id', '=', 'products.cat_id')
            ->leftjoin('u_o_m_s', 'u_o_m_s.id', '=', 'products.uom_id')
            ->select('products.*', 'categories.cat_name','u_o_m_s.uom_name')
            ->where('products.product_status','=','Y')
            ->get();
        } 
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <td class="text-center"><strong>Sr#</strong></td>
                    <td class="text-center"><strong>Product</strong></td>
                    <td class="text-center"><strong>Barcode</strong></td>
                    <td class="text-center"><strong>Category</strong></td>
                    <td class="text-center"><strong>UOM</strong></td>
                    <td class="text-center"><strong>Qty</strong></td>
                    <td class="text-center"><strong>Reorder Qty</strong></td>
                    <td class="text-center"><strong>Cost Price</strong></td>
                    <td class="text-center"><strong>Sale Price</strong></td>
                    <td class="text-center"><strong>Entry date</strong></td>
                </tr>
            </thead>
        <tbody>';

        if($products->count()>0)
        {
            foreach($products as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->product_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->UPC_EAN.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cat_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->uom_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->reorder_qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->costprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->fretailprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td class="text-center" colspan="10">No record present against your search</td></tr>';  
        }
        $output .='</tbody></table>';
        $total=$products->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Product List'
        ]);
    }
    public function stockreport(Request $request)
    {
        return view('productreports.stockreport');
    }
    //products fetching for stock movement report
    public function fetchstock(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $status=$request->status;
        $pucrhase = DB::table('stock_movements')
        ->select('stock_movements.invoice_no', 'stock_movements.total_cost','stock_movements.cost_price', 'stock_movements.qty', 'stock_movements.created_at', 'suppliers.supp_name', 'suppliers.company_name', 'products.product_name', 'u_o_m_s.uom_name')
        ->leftJoin('products','products.id','=','stock_movements.prod_id')
        ->leftJoin('suppliers','suppliers.id','=','stock_movements.supp_id')
        ->join('u_o_m_s','u_o_m_s.id','=','products.uom_id')
        ->whereDate('stock_movements.created_at','>=',$from)
        ->whereDate('stock_movements.created_at','<=',$to)
        ->where('stock_movements.stock_status','=',$status)
        ->get();  
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <td class="text-center"><strong>Sr#</strong></td>
                    <td class="text-center"><strong>Invoice</strong></td>
                    <td class="text-center"><strong>Product</strong></td>
                    <td class="text-center"><strong>UOM</strong></td>
                    <td class="text-center"><strong>Qty</strong></td>
                    <td class="text-center"><strong>Price</strong></td>
                    <td class="text-center"><strong>Total Price</strong></td>
                    <td class="text-center"><strong>Company</strong></td>
                    <td class="text-center"><strong>Supplier</strong></td>
                    <td class="text-center"><strong>Entry date</strong></td>
                </tr>
            </thead>
        <tbody>';

        if($pucrhase->count()>0)
        {
            foreach($pucrhase as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->product_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->uom_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cost_price.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_cost.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->company_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td class="text-center" colspan="10">No record present against your search</td></tr>';  
        }
        $output .='</tbody></table>';
        $total=$pucrhase->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Stock Movement'
        ]);
    }
      
    //fetching reorder products
    public function fetchreorder(Request $request)
    { 
        $products = DB::table('products')
        ->select('products.product_name', 'products.UPC_EAN', 'products.qty', 'products.reorder_qty', 'products.costprice', 'products.fretailprice', 'products.created_at', 'u_o_m_s.uom_name', 'categories.cat_name')
        ->join('u_o_m_s','products.uom_id','=','u_o_m_s.id')
        ->join('categories','products.cat_id','=','categories.id')
        ->where('products.qty','<=',DB::raw('products.reorder_qty'))
        ->where('product_status','=','Y')
        ->get();
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <td class="text-center"><strong>Sr#</strong></td>
                    <td class="text-center"><strong>Product</strong></td>
                    <td class="text-center"><strong>Barcode</strong></td>
                    <td class="text-center"><strong>Category</strong></td>
                    <td class="text-center"><strong>UOM</strong></td>
                    <td class="text-center"><strong>Qty</strong></td>
                    <td class="text-center"><strong>Reorder Qty</strong></td>
                    <td class="text-center"><strong>Cost Price</strong></td>
                    <td class="text-center"><strong>Sale Price</strong></td>
                    <td class="text-center"><strong>Entry date</strong></td>
                </tr>
            </thead>
        <tbody>';

        if($products->count()>0)
        {
            foreach($products as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->product_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->UPC_EAN.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cat_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->uom_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->reorder_qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->costprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->fretailprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No reorderable product is present in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $total=$products->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Reorder Level Products'
        ]);
       
    }
       
    //fetching expire products
    public function fetchexpire(Request $request)
    {
        $products='';
        
        $products = DB::table('products')
        ->select('products.product_name','products.expirydate','products.UPC_EAN', 'products.qty', 'products.reorder_qty', 'products.costprice', 'products.fretailprice', 'products.created_at', 'u_o_m_s.uom_name', 'categories.cat_name')
        ->join('u_o_m_s','products.uom_id','=','u_o_m_s.id')
        ->join('categories','products.cat_id','=','categories.id')
        ->where('products.product_status','=','Y')
        ->where('products.expirydate','<=', Carbon::now())
        ->get();    
        
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <td class="text-center"><strong>Sr#</strong></td>
                    <td class="text-center"><strong>Product</strong></td>
                    <td class="text-center"><strong>Barcode</strong></td>
                    <td class="text-center"><strong>Category</strong></td>
                    <td class="text-center"><strong>UOM</strong></td>
                    <td class="text-center"><strong>Qty</strong></td>
                    <td class="text-center"><strong>Reorder Qty</strong></td>
                    <td class="text-center"><strong>Cost Price</strong></td>
                    <td class="text-center"><strong>Sale Price</strong></td>
                    <td class="text-center"><strong>Expiey Date</strong></td>
                    <td class="text-center"><strong>Entry Date</strong></td>
                </tr>
            </thead>
        <tbody>';

        if($products->count()>0)
        {
            foreach($products as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->product_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->UPC_EAN.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cat_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->uom_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->reorder_qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->costprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->fretailprice.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->expirydate)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">There is no expired product in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $total=$products->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Expired Products'
        ]);
    }
    //return customer account view
    public function customeraccountreport(Request $request)
    {
        return view('accountreports.customeraccountreport');
    }
    //fetch all customer data
    public function fetchcustaccount(Request $request)
    {
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $account = DB::table('customer_accounts')
        ->select('customers.cust_name', DB::raw("SUM(customer_accounts.total_bill_amount) as total_bill_amount"), DB::raw("SUM(customer_accounts.paid_amount) as paid_amount"), DB::raw("SUM(customer_accounts.balance) as balance"))
        ->join('customers','customers.id','=','customer_accounts.cust_id')
        ->groupBy('customers.cust_name')
        ->get(); 

        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Customer</strong></th>
                    <th class="text-center"><strong>Total Bill Amount</strong></th>
                    <th class="text-center"><strong>Total Paid Amount</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_bill_amount+=$list->total_bill_amount;
                $total_paid_amount+=$list->paid_amount;
                $total_balance+=$list->balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Receivables :</td>
                            <td class="text-right pl-4">'.$total_bill_amount.'</td>
                        </tr>
                        <tr>
                            <td>Total Received :</td>
                            <td class="text-right pl-4">'.$total_paid_amount.'</td>
                        </tr>
                        <tr>
                            <td>Net Receivables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Account',
            'rpt_footer'=>$footer_data,
        ]);

    }
    //fetch single customer data
    public function fetchsinglecustaccount(Request $request)
    {

        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $chq_total=0;
        $pre_balance=0;
        $no_of_chqs=DB::table('cheque_infos')
        ->where('cust_id','=',$request->customer)
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('cust_id','=',$request->customer)
        ->where('status','=','Due')
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }

        
        $account = CustomerAccount::where('cust_id','=',$request->customer)
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->get();

        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Total Bill Amount</strong></th>
                    <th class="text-center"><strong>Paid Amount</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    <th class="text-center"><strong>Pre Balance</strong></th>
                    <th class="text-center"><strong>Total</strong></th>
                    <th class="text-center"><strong>Payment Method</strong></th>
                    <th class="text-center"><strong>Date</strong></th>   
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_bill_amount+=$list->total_bill_amount;
                $total_paid_amount+=$list->paid_amount;
                $total_balance+=$list->balance;
                $cust_acc=CustomerAccount::
                where('cust_id','=',$list->cust_id)
                ->where('id','<',$list->id)
                ->sum('balance');
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.$pre_balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.($list->balance + $pre_balance).'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->payment_method.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Unpaid Cheques Amount :</td>
                            <td class="text-right pl-4">'.$chq_total.'</td>
                        </tr>
                        <tr>
                            <td>Total Receivables :</td>
                            <td class="text-right pl-4">'.$total_bill_amount.'</td>
                        </tr>
                        <tr>
                            <td>Total Received :</td>
                            <td class="text-right pl-4">'.$total_paid_amount.'</td>
                        </tr>
                        <tr>
                            <td>Net Receivables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Account',
            'rpt_footer'=>$footer_data,
        ]);

    }
    //supplier account  
    public function supplieraccountreport(Request $request)
    {
        $supp=Supplier::where('status','=','Y')->get();
        return view('accountreports.supplieraccountreport',compact('supp'));
    }

    // fetch supplier account
    public function fetchsuppaccount(Request $request)
    {
        $total_bill_amount=0;
        $total_paid_amount=0;
        $total_balance=0;
        $account = DB::table('supplier_accounts')
        ->select('suppliers.supp_name', DB::raw("SUM(supplier_accounts.total_bill_amount) as total_bill_amount"), DB::raw("SUM(supplier_accounts.paid_amount) as paid_amount"), DB::raw("SUM(supplier_accounts.balance) as balance"))
        ->join('suppliers','suppliers.id','=','supplier_accounts.supp_id')
        ->groupBy('suppliers.supp_name')
        ->get(); 

        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Supplier</strong></th>
                    <th class="text-center"><strong>Total Bill Amount</strong></th>
                    <th class="text-center"><strong>Total Paid Amount</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_bill_amount+=$list->total_bill_amount;
                $total_paid_amount+=$list->paid_amount;
                $total_balance+=$list->balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Receivables :</td>
                            <td class="text-right pl-4">'.$total_bill_amount.'</td>
                        </tr>
                        <tr>
                            <td>Total Received :</td>
                            <td class="text-right pl-4">'.$total_paid_amount.'</td>
                        </tr>
                        <tr>
                            <td>Net Receivables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Supplier Account',
            'rpt_footer'=>$footer_data,
        ]);

    }

    // fetch single supplier account
    public function fetchsinglesuppaccount(Request $request)
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
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->where('status','=','Due')
        ->count();
        $chq=DB::table('cheque_infos')
        ->select(DB::raw("SUM(chq_amount) as chq_amount"))
        ->where('supp_id','=',$request->supplier_id)
        ->where('status','=','Due')
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->get();
        if($chq[0]->chq_amount)
        {
            $chq_total=$chq[0]->chq_amount;
        }
        //single customer   
        $account=SupplierAccount::where('supp_id','=',$request->supplier_id)
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->get();

        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Total Bill Amount</strong></th>
                    <th class="text-center"><strong>Paid Amount</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    <th class="text-center"><strong>Pre Balance</strong></th>
                    <th class="text-center"><strong>Total</strong></th>
                    <th class="text-center"><strong>Payment Method</strong></th>
                    <th class="text-center"><strong>Date</strong></th>   
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_bill_amount+=$list->total_bill_amount;
                $total_paid_amount+=$list->paid_amount;
                $total_balance+=$list->balance;
                $cust_acc=SupplierAccount::
                where('supp_id','=',$list->supp_id)
                ->where('id','<',$list->id)
                ->sum('balance');
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.$pre_balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.($list->balance + $pre_balance).'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->payment_method.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class="table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Unpaid Cheques Amount :</td>
                            <td class="text-right pl-4">'.$chq_total.'</td>
                        </tr>
                        <tr>
                            <td>Total Receivables :</td>
                            <td class="text-right pl-4">'.$total_bill_amount.'</td>
                        </tr>
                        <tr>
                            <td>Total Received :</td>
                            <td class="text-right pl-4">'.$total_paid_amount.'</td>
                        </tr>
                        <tr>
                            <td>Net Receivables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Supplier Account',
            'rpt_footer'=>$footer_data,
        ]);

    }

    // employee account view
    public function empaccountreport()
    {
        $emp=Employee::select('id','emp_name')
        ->where('status','=','Y')->get();
        return view('empaccounts.empaccountreport',compact('emp'));
    }

    //all employees account
    public function fetchempaccount(Request $reuest)
    {
        $total_Earnings=0;
        $total_withdraw=0;
        $total_balance=0;
        $account = DB::table('employee_accounts')
        ->select('employees.emp_name', DB::raw("sum(employee_accounts.emp_earning) as emp_earning"), 
        DB::raw("sum(employee_accounts.emp_withdraw_amount) as emp_withdraw_amount"), 
        DB::raw("sum(employee_accounts.balance) as balance"))
        ->join('employees','employee_accounts.emp_id','=','employees.id')
        ->groupBy('employees.emp_name')
        ->get();

        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Employee</strong></th>
                    <th class="text-center"><strong>Total Earnings</strong></th>
                    <th class="text-center"><strong>Total Withdraw</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_Earnings+=$list->emp_earning;
                $total_withdraw+=$list->emp_withdraw_amount;
                $total_balance+=$list->balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_earning.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_withdraw_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Earnings :</td>
                            <td class="text-right pl-4">'.$total_Earnings.'</td>
                        </tr>
                        <tr>
                            <td>Total Withdraw :</td>
                            <td class="text-right pl-4">'.$total_withdraw.'</td>
                        </tr>
                        <tr>
                            <td>Net Balance :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Employee Account',
            'rpt_footer'=>$footer_data,
        ]);
    }

    //single employee account
    public function fetchsingleempaccount(Request $request)
    {
        $total_Earnings=0;
        $total_withdraw=0;
        $total_balance=0;
        $pre_balance=0;
        $account = EmployeeAccount::where('emp_id','=',$request->emp_id)
        ->wheredate('created_at','>=',$request->from)
        ->wheredate('created_at','<=',$request->to)
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Total Earnings</strong></th>
                    <th class="text-center"><strong>Total Withdraw</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                    <th class="text-center"><strong>Pre Balance</strong></th>
                    <th class="text-center"><strong>Total</strong></th>
                    <th class="text-center"><strong>Processed By</strong></th>
                    <th class="text-center"><strong>Date</strong></th>  
                </tr>
            </thead>
        <tbody>';

        if($account->count()>0)
        {
            foreach($account as $key=> $list)
            {  
                $sr=$key+1;
                $total_Earnings+=$list->emp_earning;
                $total_withdraw+=$list->emp_withdraw_amount;
                $total_balance+=$list->balance;
                $cust_acc=EmployeeAccount::
                where('emp_id','=',$list->emp_id)
                ->where('id','<',$list->id)
                ->sum('balance');
                if($cust_acc)
                {
                    $pre_balance=$cust_acc;
                }
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_earning.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_withdraw_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.$pre_balance.'</td>
                    <td class="text-center" style="padding: 1px;">'.($list->balance + $pre_balance).'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->processed_by.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Earnings :</td>
                            <td class="text-right pl-4">'.$total_Earnings.'</td>
                        </tr>
                        <tr>
                            <td>Total Withdraw :</td>
                            <td class="text-right pl-4">'.$total_withdraw.'</td>
                        </tr>
                        <tr>
                            <td>Net Balance :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$account->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Employee Account',
            'rpt_footer'=>$footer_data,
        ]);
    }

    public function allusersale(Request $request)
    {
        return view('salesreport.allusersale');
    }
    public function fetchsales(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $total_sale=0;
        $total_profit=0;
        $sales = DB::table('sales')
        ->select('sales.*')
        ->whereDate('sales.sale_date', '>=', $from)
        ->whereDate('sales.sale_date', '<=', $to)
        ->where('sales.status','=','Complete')
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Date</strong></th>
                    <th class="text-center"><strong>Order Total</strong></th>
                    <th class="text-center"><strong>Discount</strong></th>
                    <th class="text-center"><strong>Total Amount</strong></th>
                    <th class="text-center"><strong>Profit</strong></th>  
                </tr>
            </thead>
        <tbody>';
        if($sales->count()>0)
        {
            foreach($sales as $key=> $list)
            {  
                $sr=$key+1;
                $total_sale+=$list->total_amount;
                $total_profit+=$list->profit;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->order_total.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->discount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->profit.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Sales :</td>
                            <td class="text-right pl-4">'.$total_sale.'</td>
                        </tr>
                        <tr>
                            <td>Total Sale Profit :</td>
                            <td class="text-right pl-4">'.$total_profit.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sales',
            'rpt_footer'=>$footer_data,
        ]);
        
          
    }
    //single user sales
    public function fetchsinglesales(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $user = $request->user;
        $total_sale=0;
        $total_profit=0;
        $sales = DB::table('sales')
        ->select('sales.*')
        ->whereDate('sales.sale_date', '>=', $from)
        ->whereDate('sales.sale_date', '<=', $to)
        ->where('sales.status','=','Complete')
        ->where('sales.user_id', '=', $user)
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Date</strong></th>
                    <th class="text-center"><strong>Order Total</strong></th>
                    <th class="text-center"><strong>Discount</strong></th>
                    <th class="text-center"><strong>Total Amount</strong></th>
                    <th class="text-center"><strong>Profit</strong></th>  
                </tr>
            </thead>
        <tbody>';
        if($sales->count()>0)
        {
            foreach($sales as $key=> $list)
            {  
                $sr=$key+1;
                $total_sale+=$list->total_amount;
                $total_profit+=$list->profit;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->invoice_no.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->order_total.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->discount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_amount.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->profit.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Sales :</td>
                            <td class="text-right pl-4">'.$total_sale.'</td>
                        </tr>
                        <tr>
                            <td>Total Sale Profit :</td>
                            <td class="text-right pl-4">'.$total_profit.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sales',
            'rpt_footer'=>$footer_data,
        ]);
        
          
    }
    public function singleusersale(Request $request)
    {
        $users = User::get();   
        return view('salesreport.singleusersale',compact('users'));
    }
    public function fetchsaledetails(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $total_sale=0;
        $total_profit=0;
        $sales = DB::table('sales')
        ->select('sales.*')
        ->whereDate('sales.sale_date', '>=', $from)
        ->whereDate('sales.sale_date', '<=', $to)
        ->where('sales.status','=','Complete')
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">';
        if($sales->count()>0)
        {
            foreach($sales as $key=> $list)
            {  
                $invoice_no=$list->invoice_no;
                $total_sale+=$list->total_amount;
                $total_profit+=$list->profit;
                $output.=' 
                <thead>
                <tr style="background-color:black;color:#ffffff">
                    <th class="text-center"><strong>Invoice # :&nbsp;&nbsp;'.$list->invoice_no.'</strong></th>
                    <th class="text-center"><strong>Date :&nbsp;&nbsp;'.Carbon::parse($list->created_at)->format('d-M-Y').'</strong></th>
                    <th class="text-center"><strong>Sale :&nbsp;&nbsp;'.$list->total_amount.'</strong></th>
                    <th class="text-center"><strong>Profit :&nbsp;&nbsp;'.$list->profit.'</strong></th>
                </tr>
            </thead>
            <tbody>
            <tr style="padding: 1px;background-color:lightgray;color:black">
                <td class="text-center" style="padding: 1px;"><b>Sr#</b></td>
                <td class="text-center" style="padding: 1px;"><b>Product</b></td>
                <td class="text-center" style="padding: 1px;"><b>Qty</b></td>
                <td class="text-center" style="padding: 1px;"><b>Cost Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Retail Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Final Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Total Price</b></td>
            </tr>';
            
            $saledetails=DB::table('sale_details')
            ->select('sale_details.product_name','sale_details.qty','sale_details.cost_price','sale_details.retail_price','sale_details.fretail_price','sale_details.total_fretailprice')
            ->where('sale_details.invoice_no', '=', $invoice_no)
            ->where('sale_details.status','=','Complete')
            ->where('sale_details.qty','>',0)
            ->get();
                foreach($saledetails as $key=>$delist)
                {
                   $output.='
                    <tr style="padding: 1px;">
                        <td class="text-center" style="padding: 1px;">'.($key+1).'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->product_name.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->qty.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->cost_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->retail_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->fretail_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->total_fretailprice.'</td>
                    </tr>';
                }
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Sales :</td>
                            <td class="text-right pl-4">'.$total_sale.'</td>
                        </tr>
                        <tr>
                            <td>Total Sale Profit :</td>
                            <td class="text-right pl-4">'.$total_profit.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sale Detail',
            'rpt_footer'=>$footer_data,
        ]);
    }
    //single user
    public function fetchsinglesaledetails(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $user = $request->user;
        $total_sale=0;
        $total_profit=0;
        $sales = DB::table('sales')
        ->select('sales.*')
        ->whereDate('sales.sale_date', '>=', $from)
        ->whereDate('sales.sale_date', '<=', $to)
        ->where('sales.user_id', '=', $user)
        ->where('sales.status','=','Complete')
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">';
        if($sales->count()>0)
        {
            foreach($sales as $key=> $list)
            {  
                $invoice_no=$list->invoice_no;
                $total_sale+=$list->total_amount;
                $total_profit+=$list->profit;
                $output.=' 
                <thead>
                <tr style="background-color:black;color:#ffffff">
                    <th class="text-center"><strong>Invoice # :&nbsp;&nbsp;'.$list->invoice_no.'</strong></th>
                    <th class="text-center"><strong>Date :&nbsp;&nbsp;'.Carbon::parse($list->created_at)->format('d-M-Y').'</strong></th>
                    <th class="text-center"><strong>Sale :&nbsp;&nbsp;'.$list->total_amount.'</strong></th>
                    <th class="text-center"><strong>Profit :&nbsp;&nbsp;'.$list->profit.'</strong></th>
                </tr>
            </thead>
            <tbody>
            <tr style="padding: 1px;background-color:lightgray;color:black">
                <td class="text-center" style="padding: 1px;"><b>Sr#</b></td>
                <td class="text-center" style="padding: 1px;"><b>Product</b></td>
                <td class="text-center" style="padding: 1px;"><b>Qty</b></td>
                <td class="text-center" style="padding: 1px;"><b>Cost Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Retail Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Final Price</b></td>
                <td class="text-center" style="padding: 1px;"><b>Total Price</b></td>
            </tr>';
            
            $saledetails=DB::table('sale_details')
            ->select('sale_details.product_name','sale_details.qty','sale_details.cost_price','sale_details.retail_price','sale_details.fretail_price','sale_details.total_fretailprice')
            ->where('sale_details.invoice_no', '=', $invoice_no)
            ->where('sale_details.status','=','Complete')
            ->where('sale_details.qty','>',0)
            ->get();
                foreach($saledetails as $key=>$delist)
                {
                   $output.='
                    <tr style="padding: 1px;">
                        <td class="text-center" style="padding: 1px;">'.($key+1).'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->product_name.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->qty.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->cost_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->retail_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->fretail_price.'</td>
                        <td class="text-center" style="padding: 1px;">'.$delist->total_fretailprice.'</td>
                    </tr>';
                }
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Sales :</td>
                            <td class="text-right pl-4">'.$total_sale.'</td>
                        </tr>
                        <tr>
                            <td>Total Sale Profit :</td>
                            <td class="text-right pl-4">'.$total_profit.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sale Detail',
            'rpt_footer'=>$footer_data,
        ]);
    }

    // Sale return report view
    public function salereturnreport(Request $request)
    {
        $prod=Product::select('id','product_name')
        ->where('product_status','=','Y')->get();
       return view('Sale.salereturnreport',compact('prod'));
    }

    // Date range sale return
    public function fetchsalereturn(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $products=$request->product;
        $total_qty=0;
        $total_return=0;
        $sales_return = DB::table('sale_return_details')
        ->select('products.product_name', 'sale_return_details.invoice', 'sale_return_details.return_qty', 'sale_return_details.price', 'sale_return_details.total_price', 'sale_return_details.created_at')
        ->join('products','products.id','=','sale_return_details.prod_id')
        ->where('sale_return_details.return_qty','>',0)
        ->whereDate('sale_return_details.created_at','>=',$from)
        ->whereDate('sale_return_details.created_at','<=',$to)
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Return Date</strong></th>
                    <th class="text-center"><strong>Product</strong></th>
                    <th class="text-center"><strong>Qty</strong></th>
                    <th class="text-center"><strong>Price</strong></th>
                    <th class="text-center"><strong>Total Price</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($sales_return->count()>0)
        {
            foreach($sales_return as $key=> $list)
            {  
                $sr=$key+1;
                $total_qty+=$list->return_qty;
                $total_return+=$list->total_price;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->invoice.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->product_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->return_qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->price.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_price.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Return Products :</td>
                            <td class="text-right pl-4">'.$total_qty.'</td>
                        </tr>
                        <tr>
                            <td>Total Return Amount :</td>
                            <td class="text-right pl-4">'.$total_return.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales_return->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sale Return',
            'rpt_footer'=>$footer_data,
        ]);
    }

    // Product date range
    public function fetchprodsalereturn(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $products=$request->product;
        $total_qty=0;
        $total_return=0;
        $sales_return = DB::table('sale_return_details')
        ->select('products.product_name', 'sale_return_details.invoice', 'sale_return_details.return_qty', 'sale_return_details.price', 'sale_return_details.total_price', 'sale_return_details.created_at')
        ->join('products','products.id','=','sale_return_details.prod_id')
        ->where('sale_return_details.return_qty','>',0)
        ->where('sale_return_details.prod_id','=',$products)
        ->whereDate('sale_return_details.created_at','>=',$from)
        ->whereDate('sale_return_details.created_at','<=',$to)
        ->get();
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Invoice #</strong></th>
                    <th class="text-center"><strong>Return Date</strong></th>
                    <th class="text-center"><strong>Qty</strong></th>
                    <th class="text-center"><strong>Price</strong></th>
                    <th class="text-center"><strong>Total Price</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($sales_return->count()>0)
        {
            foreach($sales_return as $key=> $list)
            {  
                $sr=$key+1;
                $total_qty+=$list->return_qty;
                $total_return+=$list->total_price;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->invoice.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->return_qty.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->price.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->total_price.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Return Products :</td>
                            <td class="text-right pl-4">'.$total_qty.'</td>
                        </tr>
                        <tr>
                            <td>Total Return Amount :</td>
                            <td class="text-right pl-4">'.$total_return.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$sales_return->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Sale Return',
            'rpt_footer'=>$footer_data,
        ]);
    }

    //profit loss report

    public function profitlossreport()
    {
        return view('Sale.profitloss');
    }
    //load profit loss
    public function fetchprofitloss(Request $request)
    {
        $from=$request->from;
        $to=$request->to;
        $expense=DB::table('expenses')
        ->select(DB::raw("sum(exp_amount) as total_expences"))
        ->whereDate('created_at','>=',$from)
        ->whereDate('created_at','<=',$to)
        ->get();

        $profit=DB::table('sales')
        ->select(DB::raw("sum(profit) as sale_profit"))
        ->whereDate('created_at','>=',$from)
        ->whereDate('created_at','<=',$to)
        ->get();

        return response()->json([
         'expences'=>$expense[0]->total_expences,
         'profit'=>$profit[0]->sale_profit,
        ]);

    }

    public function chequelistreport(Request $request)
    { 
        return view('chequesreport.chequelist');
    }
    public function fetchcheques(Request $request)
    {
        $total_chqs=0;
        $from = $request->from;
        $to = $request->to;
        $status = $request->status;        
        $cheques = DB::table('cheque_infos')
        ->select('cheque_infos.*', 'customers.cust_name')
        ->join('customers','customers.id','=','cheque_infos.cust_id')
        ->where('cheque_infos.status','=',$status)
        ->whereDate('cheque_infos.created_at','>=',$from)
        ->whereDate('cheque_infos.created_at','=',$to)
        ->get();
         
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Customer</strong></th>
                    <th class="text-center"><strong>Cheque No#</strong></th>
                    <th class="text-center"><strong>Due Date</strong></th>
                    <th class="text-center"><strong>Clearance Date</strong></th>
                    <th class="text-center"><strong>Amount</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($cheques->count()>0)
        {
            foreach($cheques as $key=> $list)
            {  
                $clear_date="Not Cleared";
                if($list->clear_date)
                {
                    $clear_date=Carbon::parse($list->clear_date)->format('d-M-Y');
                }
                $sr=$key+1;
                $total_chqs+=$list->chq_amount;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->chq_number.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$clear_date.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->chq_amount.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Cheque Amount :</td>
                            <td class="text-right pl-4">'.$total_chqs.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$cheques->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Cheques',
            'rpt_footer'=>$footer_data,
        ]);
    }
    
    public function fetchsuppliercheques(Request $request)
    {        
        $total_chqs=0;
        $from = $request->from;
        $to = $request->to;
        $status = $request->status;
        
        $cheques = DB::table('cheque_infos')
        ->select('cheque_infos.*', 'suppliers.supp_name')
        ->join('suppliers','suppliers.id','=','cheque_infos.supp_id')
        ->where('cheque_infos.status','=',$status)
        ->whereDate('cheque_infos.created_at','>=',$from)
        ->whereDate('cheque_infos.created_at','=',$to)
        ->get();
         
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Supplier</strong></th>
                    <th class="text-center"><strong>Cheque No#</strong></th>
                    <th class="text-center"><strong>Due Date</strong></th>
                    <th class="text-center"><strong>Clearance Date</strong></th>
                    <th class="text-center"><strong>Amount</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($cheques->count()>0)
        {
            foreach($cheques as $key=> $list)
            {  
                $clear_date="Not Cleared";
                if($list->clear_date)
                {
                    $clear_date=Carbon::parse($list->clear_date)->format('d-M-Y');
                }
                $sr=$key+1;
                $total_chqs+=$list->chq_amount;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->chq_number.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$clear_date.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->chq_amount.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Cheque Amount :</td>
                            <td class="text-right pl-4">'.$total_chqs.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$cheques->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Supplier Cheques',
            'rpt_footer'=>$footer_data,
        ]);
       
    }
    
    public function fetchcapital(Request $request)
    {
        
        $business_capital = 0;
        $supplierpayable = 0;
        $supplierreceivable = 0;
        $customerpayable = 0;
        $customerreceiveable = 0;
        $cashinhand = 0;
        $qty = Product::select('qty')->sum('qty');
        $fprice = Product::select('fretailprice')->sum('fretailprice');
        $stockvalue = $fprice * $qty;
        $cashregister = CashRegister::select('cash_in_hand')
        ->where('status','=',"open")
        ->where('user_id',Auth::user()->id)
        ->get();
        foreach ($cashregister as $list)
        {
            $cashinhand = $list->cash_in_hand;
        }
        $customerreceiveable = DB::table('customer_accounts')
        ->where('customer_accounts.balance','>',0)->sum('customer_accounts.balance');
        $customerpayable = DB::table('customer_accounts')
        ->where('customer_accounts.balance','<',0)->sum('customer_accounts.balance');
        $supplierreceivable = DB::table('supplier_accounts')
        ->where('supplier_accounts.balance','<',0)->sum('supplier_accounts.balance');
        $supplierpayable = DB::table('supplier_accounts')
        ->where('supplier_accounts.balance','>',0)->sum('supplier_accounts.balance');
        $business_capital = $stockvalue + $cashinhand + $customerreceiveable + $customerpayable + $supplierreceivable + $supplierpayable;
        $output ='<center><table id="" class="display table-sm table-hover container1">
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">Current Stock Value</th>
            <td style="font-size:14px;padding: 4px">'.$stockvalue.'</td>
        </tr>
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">Cash in Hand</th>
            <td style="font-size:14px;padding: 4px">'.$cashinhand.'</td>
        </tr>
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">All Customer Receivables</th>
            <td style="font-size:14px;padding: 4px">'.$customerreceiveable.'</td>
        </tr>
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">All Customer Payables</th>
            <td style="font-size:14px;padding: 4px">'.$customerpayable.'</td>
        </tr>
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">All Suppliers Receivables</th>
            <td style="font-size:14px;padding: 4px">'.$supplierreceivable.'</td>
        </tr>
        <tr style="padding: 4px;">
            <th style="font-size:14px;padding: 4px;">All Suppliers Payables</th>
            <td style="font-size:14px;padding: 4px">'.$supplierpayable.'</td>
        </tr>
        </table>';
    $output .='<br>
    <h3><b>Business Capital</b>&nbsp;&nbsp;&nbsp; <span>'.$business_capital.'</span></h3></center>
    ';
    echo $output;
        
        
    }
    public function cashflow(Request $request)
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
        return view('reports.cashflow',compact('mytime','mytime1'));
    }
    public function fetchcashflow(Request $request)
    {
        $cashflow='';
        $from = $request->from;
        $to = $request->to;
        
        $cashflow = DB::table('cash_flows')
        ->whereDate('cash_flows.created_at', '>=', $from)
        ->whereDate('cash_flows.created_at', '<=', $to)
        ->select('cash_flows.*')
        ->get();
        $output='';
        if($cashflow->count()>0)
        {
            $output .='<table id="example" class="display table table-striped table-hover container1">
            <thead style="padding: 4px;">
                <tr style="padding: 4px;">
                    <th style="font-size:14px;padding: 4px;">Sr#</th>
                    <th style="font-size:14px;padding: 4px;width:10%">Transaction Date</th>
                    <th style="font-size:14px;padding: 4px;">Party</th> 
                    <th style="font-size:14px;padding: 4px;">UOM</th>
                    <th style="font-size:14px;padding: 4px;">QTY</th>
                    <th style="font-size:14px;padding: 4px;">Total Price</th>
                    <th style="font-size:14px;padding: 4px;">Company</th>
                    <th style="font-size:14px;padding: 4px;">Supplier</th>
                </tr>
            </thead>
          <tbody style="padding: 1px;">';
          foreach($pucrhase as $key=> $list)
          {  $sr=$key+1;
              $output .='<tr style="padding: 1px;">
              <td style="padding: 1px;">'.$list->Invoice_no.'</td>
              <td style="padding: 1px;width:10%">'.date('d-m-Y', strtotime($list->purchase_date)).'</td>
              <td style="padding: 1px;">'.$list->prod_name.'</td>
              <td style="padding: 1px;">'.$list->uom_name.'</td>
              <td style="padding: 1px;">'.$list->QTY.'</td>
              <td style="padding: 1px;">'.$list->total_cost.'</td>
              <td style="padding: 1px;">'.$list->company_name.'</td>
              <td style="padding: 1px;">'.$list->supp_name.'</td>
              </tr>';
          }
          $output .='</tbody></table>';
          echo $output;
        }
        else 
        {
	      echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
	    }
    }
    public function customerreceivable()
    {
        $cust=Customer::where('status','=','Y')->get();
        return view('reports.allreceivable',compact('cust'));
    }   
    public function fetchallreceivale(Request $request)
    {
        $total_balance=0;
        $allcustomerreceiveable = DB::table('customer_accounts')
        ->select('customers.cust_name', 'customers.address', 'customers.contact', DB::raw("SUM(customer_accounts.balance) as Balance"))
        ->join('customers','customers.id','=','customer_accounts.cust_id')
        ->where('customer_accounts.balance','>',0)
        ->groupBy('customers.cust_name')
        ->get();
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Customer</strong></th>
                    <th class="text-center"><strong>Address</strong></th>
                    <th class="text-center"><strong>Contact</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($allcustomerreceiveable->count()>0)
        {
            foreach($allcustomerreceiveable as $key=> $list)
            {  
                
                $sr=$key+1;
                $total_balance+=$list->Balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->Balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '<div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Receivables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$allcustomerreceiveable->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Receivables',
            'rpt_footer'=>$footer_data,
        ]);
    }
     
    public function fetchcustreceivable(Request $request)
    {
        $total_balance=0;
        $customer = $request->cust_id;
        $customer_receiveable = DB::table('customer_accounts')
        ->where('balance','>',0)
        ->where('cust_id','=',$customer)
        ->get();
       $output='
       <table class="table-sm table-bordered table-condensed w-100">
           <thead>
               <tr>
                   <th class="text-center"><strong>Sr#</strong></th>
                   <th class="text-center"><strong>Total Bill Amount</strong></th>
                   <th class="text-center"><strong>Paid Amount</strong></th>
                   <th class="text-center"><strong>Balance</strong></th>
                   <th class="text-center"><strong>Date</strong></th>
               </tr>
           </thead>
       <tbody>';
       if($customer_receiveable->count()>0)
       {
           foreach($customer_receiveable as $key=> $list)
           {  
               
               $sr=$key+1;
               $total_balance+=$list->Balance;
               $output .='
               <tr style="padding: 1px;">
                   <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                   <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
           }
       }else{
           $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
       }
       $output .='</tbody></table>';
       $footer_data=
       '<div class="d-flex">
           <div class="col-sm-12 text-left">
               <table class"table-sm table-condensed">
                   <tbody>
                       <tr>
                           <td>Total Receivables :</td>
                           <td class="text-right pl-4">'.$total_balance.'</td>
                       </tr>
                       
                   </tbody>
               </table>
           </div>
       </div>';
       $total=$customer_receiveable->count();
       return response()->json([
           'output'=>$output,
           'total'=>$total,
           'rpt_name'=>'Customer Receivables',
           'rpt_footer'=>$footer_data,
       ]);
    }
    public function allpayables()
    {
        $cust=Customer::where('status','=','Y')->get();
        return view('reports.allpayables',compact('cust'));
    }   
    public function fetchallpayables(Request $request)
    {
        $total_balance=0;
        $allcustomerpayables = DB::table('customer_accounts')
        ->select('customers.cust_name', 'customers.address', 'customers.contact', DB::raw("SUM(customer_accounts.balance) as Balance"))
        ->join('customers','customers.id','=','customer_accounts.cust_id')
        ->where('customer_accounts.balance','<',0)
        ->groupBy('customers.cust_name')
        ->get();
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Customer</strong></th>
                    <th class="text-center"><strong>Address</strong></th>
                    <th class="text-center"><strong>Contact</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($allcustomerpayables->count()>0)
        {
            foreach($allcustomerpayables as $key=> $list)
            {  
                
                $sr=$key+1;
                $total_balance+=$list->Balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->Balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '<div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Payables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$allcustomerpayables->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Payables',
            'rpt_footer'=>$footer_data,
        ]);
    }
    public function singlepayable(Request $request)
    {
        $total_balance=0;
        $customer = $request->cust_id;
        $customer_receiveable = DB::table('customer_accounts')
        ->where('balance','<',0)
        ->where('cust_id','=',$customer)
        ->get();
       $output='
       <table class="table-sm table-bordered table-condensed w-100">
           <thead>
               <tr>
                   <th class="text-center"><strong>Sr#</strong></th>
                   <th class="text-center"><strong>Total Bill Amount</strong></th>
                   <th class="text-center"><strong>Paid Amount</strong></th>
                   <th class="text-center"><strong>Balance</strong></th>
                   <th class="text-center"><strong>Date</strong></th>
               </tr>
           </thead>
       <tbody>';
       if($customer_receiveable->count()>0)
       {
           foreach($customer_receiveable as $key=> $list)
           {  
               
               $sr=$key+1;
               $total_balance+=$list->balance;
               $output .='
               <tr style="padding: 1px;">
                   <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                   <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
           }
       }else{
           $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
       }
       $output .='</tbody></table>';
       $footer_data=
       '<div class="d-flex">
           <div class="col-sm-12 text-left">
               <table class"table-sm table-condensed">
                   <tbody>
                       <tr>
                           <td>Total Payables :</td>
                           <td class="text-right pl-4">'.$total_balance.'</td>
                       </tr>
                       
                   </tbody>
               </table>
           </div>
       </div>';
       $total=$customer_receiveable->count();
       return response()->json([
           'output'=>$output,
           'total'=>$total,
           'rpt_name'=>'Customer Payables',
           'rpt_footer'=>$footer_data,
       ]);
    }   
    public function supp_payables()
    {
        $supp=Supplier::where('status','=','Y')->get();
        return view('reports.supp_payable',compact('supp'));
    }
    // all supplier payables
    public function fetchsupplierpayable(Request $request)
    {
        $total_balance=0;
        $allsupplierpayables = DB::table('supplier_accounts')
        ->select('suppliers.supp_name', 'suppliers.address', 'suppliers.contact', DB::raw("SUM(supplier_accounts.balance) as Balance"))
        ->join('suppliers','suppliers.id','=','supplier_accounts.supp_id')
        ->where('supplier_accounts.balance','>',0)
        ->groupBy('suppliers.supp_name')
        ->get();
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Supplier</strong></th>
                    <th class="text-center"><strong>Address</strong></th>
                    <th class="text-center"><strong>Contact</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($allsupplierpayables->count()>0)
        {
            foreach($allsupplierpayables as $key=> $list)
            {  
                
                $sr=$key+1;
                $total_balance+=$list->Balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->Balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '<div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Payables :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$allsupplierpayables->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Supplier Payables',
            'rpt_footer'=>$footer_data,
        ]);
        
    }

    // single supplier payables
    public function singlesupplierpayable(Request $request)
    {
        $total_balance=0;
        $supplier = $request->supp_id;
        $supplier_payable = DB::table('supplier_accounts')
        ->where('balance','>',0)
        ->where('supp_id','=',$supplier)
        ->get();
       $output='
       <table class="table-sm table-bordered table-condensed w-100">
           <thead>
               <tr>
                   <th class="text-center"><strong>Sr#</strong></th>
                   <th class="text-center"><strong>Total Bill Amount</strong></th>
                   <th class="text-center"><strong>Paid Amount</strong></th>
                   <th class="text-center"><strong>Balance</strong></th>
                   <th class="text-center"><strong>Date</strong></th>
               </tr>
           </thead>
       <tbody>';
       if($supplier_payable->count()>0)
       {
           foreach($supplier_payable as $key=> $list)
           {  
               
               $sr=$key+1;
               $total_balance+=$list->balance;
               $output .='
               <tr style="padding: 1px;">
                   <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                   <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
           }
       }else{
           $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
       }
       $output .='</tbody></table>';
       $footer_data=
       '<div class="d-flex">
           <div class="col-sm-12 text-left">
               <table class"table-sm table-condensed">
                   <tbody>
                       <tr>
                           <td>Total Payabels :</td>
                           <td class="text-right pl-4">'.$total_balance.'</td>
                       </tr>
                       
                   </tbody>
               </table>
           </div>
       </div>';
       $total=$supplier_payable->count();
       return response()->json([
           'output'=>$output,
           'total'=>$total,
           'rpt_name'=>'Supplier Payables',
           'rpt_footer'=>$footer_data,
       ]);
    }

    public function customerbalance()
    {
        $cust=Customer::where('status','=','Y')->get();
        return view('reports.customerbalance',compact('cust'));
    }   

    // all customer balances
    public function fetchbalances(Request $request)
    {
        $total_balance=0;
        $allcustomerbalance = DB::table('customer_accounts')
        ->select('customers.cust_name', 'customers.address', 'customers.contact', DB::raw("SUM(customer_accounts.balance) as Balance"))
        ->join('customers','customers.id','=','customer_accounts.cust_id')
        ->groupBy('customers.cust_name')
        ->get();
        
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Customer</strong></th>
                    <th class="text-center"><strong>Address</strong></th>
                    <th class="text-center"><strong>Contact</strong></th>
                    <th class="text-center"><strong>Balance</strong></th>
                </tr>
            </thead>
        <tbody>';
        if($allcustomerbalance->count()>0)
        {
            foreach($allcustomerbalance as $key=> $list)
            {  
                
                $sr=$key+1;
                $total_balance+=$list->Balance;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->Balance.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '<div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Balance :</td>
                            <td class="text-right pl-4">'.$total_balance.'</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$allcustomerbalance->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer Balance',
            'rpt_footer'=>$footer_data,
        ]);
    }

    // all customer balances
    public function fetchcustbalances(Request $request)
    {
        $total_balance=0;
        $customer = $request->cust_id;
        $customer_receiveable = DB::table('customer_accounts')
        ->where('cust_id','=',$customer)
        ->get();
       $output='
       <table class="table-sm table-bordered table-condensed w-100">
           <thead>
               <tr>
                   <th class="text-center"><strong>Sr#</strong></th>
                   <th class="text-center"><strong>Total Bill Amount</strong></th>
                   <th class="text-center"><strong>Paid Amount</strong></th>
                   <th class="text-center"><strong>Balance</strong></th>
                   <th class="text-center"><strong>Date</strong></th>
               </tr>
           </thead>
       <tbody>';
       if($customer_receiveable->count()>0)
       {
           foreach($customer_receiveable as $key=> $list)
           {  
               
               $sr=$key+1;
               $total_balance+=$list->balance;
               $output .='
               <tr style="padding: 1px;">
                   <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->total_bill_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->paid_amount.'</td>
                   <td class="text-center" style="padding: 1px;">'.$list->balance.'</td>
                   <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
           }
       }else{
           $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
       }
       $output .='</tbody></table>';
       $footer_data=
       '<div class="d-flex">
           <div class="col-sm-12 text-left">
               <table class"table-sm table-condensed">
                   <tbody>
                       <tr>
                           <td>Total Balance :</td>
                           <td class="text-right pl-4">'.$total_balance.'</td>
                       </tr>
                       
                   </tbody>
               </table>
           </div>
       </div>';
       $total=$customer_receiveable->count();
       return response()->json([
           'output'=>$output,
           'total'=>$total,
           'rpt_name'=>'Customer Balance',
           'rpt_footer'=>$footer_data,
       ]);
    }
    public function cashregister(Request $request)
    {
        $mytime='';
        $mytime1='';
        $users = User::get();
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
        return view('reports.cashregister',compact('mytime','mytime1','users'));
    }
    public function fetchcashregister(Request $request)
    {
        $cash_register='';
        $from = $request->from;
        $to = $request->to;
        $user = $request->user;
        if ($user=='')
        {
            $cash_register = DB::table('cash_registers')
            ->whereDate('cash_registers.closing_date', '>=', $from)
            ->whereDate('cash_registers.closing_date', '<=', $to)
            ->join('users','users.id','=','cash_registers.user_id')
            ->select('cash_registers.*','users.name')
            ->get();   
        }
        else
        {
            $cash_register = DB::table('cash_registers')
            ->whereDate('cash_registers.closing_date', '>=', $from)
            ->whereDate('cash_registers.closing_date', '<=', $to)
            ->where('cash_registers.user_id',$user)
            ->join('users','users.id','=','cash_registers.user_id')
            ->select('cash_registers.*','users.name')
            ->get();   
        }
        $output='';
        if($cash_register->count()>0)
        {
            $output .='<table id="example" class="display table table-striped table-hover container1">
            <thead style="padding: 4px;">
                <tr style="padding: 4px;">
                    <th style="font-size:14px;padding: 4px;">User Name</th>
                    <th style="font-size:14px;padding: 4px">Opening Date</th>
                    <th style="font-size:14px;padding: 4px;">Cash In Hand</th>
                    <th style="font-size:14px;padding: 4px;">Total Sale</th>
                    <th style="font-size:14px;padding: 4px;">Total Return</th>
                    <th style="font-size:14px;padding: 4px;">Closing Amount</th>
                    <th style="font-size:14px;padding: 4px;">Closing Date</th>
                </tr>
            </thead>
          <tbody style="padding: 1px;">';
          foreach($cash_register as $key=> $list)
          {  
            $sr=$key+1;
              $output .='<tr style="padding: 1px;">
              <td style="padding: 1px;">'.$list->name.'</td>
              <td style="padding: 1px;">'.date('d-m-Y', strtotime($list->opening_date)).'</td>
              <td style="padding: 1px;">'.$list->cash_in_hand.'</td>
              <td style="padding: 1px;">'.$list->total_sale.'</td>
              <td style="padding: 1px;">'.$list->total_return.'</td>
              <td style="padding: 1px;">'.$list->closing_amount.'</td>
              <td style="padding: 1px;">'.date('d-m-Y', strtotime($list->closing_date)).'</td>
              </tr>'
              ;  
          }
          $output .='</tbody></table>';
          
          echo $output;
        }
        else 
        {
	      echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
	    }
    }
    public function expensereport(Request $request)
    {
        $cat = ExpenseCategory::where('status','=','Y')->get();
        return view('reports.expensereport',compact('cat'));
    }
    
    // all expense load
    public function fetchexpense(Request $request)
    {
        $total_amount=0;
        $from = $request->from;
        $to = $request->to;
        $expense = DB::table('expenses')
        ->whereDate('expenses.exp_date', '>=', $from)
        ->whereDate('expenses.exp_date', '<=', $to)
        ->join('expense_categories','expense_categories.id','=','expenses.cat_id')
        ->select('expenses.*','expense_categories.cat_name')
        ->where('exp_status','=','Y')
        ->get();   
       
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Date</strong></th>
                    <th class="text-center"><strong>Category</strong></th>
                    <th class="text-center"><strong>Added By</strong></th>
                    <th class="text-center"><strong>Note</strong></th>
                    <th class="text-center"><strong>Amount</strong></th> 
                </tr>
            </thead>
        <tbody>';

        if($expense->count()>0)
        {
            foreach($expense as $key=> $list)
            {  
                $sr=$key+1;
                $total_amount+=$list->exp_amount;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->cat_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_addedby.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_desc.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_amount.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Expense Amount :</td>
                            <td class="text-right pl-4">'.$total_amount.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$expense->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Expense List',
            'rpt_footer'=>$footer_data,
        ]);       
    }
    //all cat expences load
    public function fetchcatexpense(Request $request)
    {
        $total_amount=0;
        $from = $request->from;
        $to = $request->to;
        $cat = $request->cat_id;
        $expense = DB::table('expenses')
        ->whereDate('expenses.exp_date', '>=', $from)
        ->whereDate('expenses.exp_date', '<=', $to)
        ->where('expenses.cat_id','=',$cat)
        ->where('exp_status','=','Y')
        ->get();   
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <th class="text-center"><strong>Sr#</strong></th>
                    <th class="text-center"><strong>Date</strong></th>
                    <th class="text-center"><strong>Added By</strong></th>
                    <th class="text-center"><strong>Note</strong></th>
                    <th class="text-center"><strong>Amount</strong></th> 
                </tr>
            </thead>
        <tbody>';

        if($expense->count()>0)
        {
            foreach($expense as $key=> $list)
            {  
                $sr=$key+1;
                $total_amount+=$list->exp_amount;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_addedby.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_desc.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->exp_amount.'</td>
                </tr>';
            }
        }else{
            $output .='<tr><td colspan="10" class="text-center">No record present  in database.</td></tr>';  
        }
        $output .='</tbody></table>';
        $footer_data=
        '
        <div class="d-flex">
            <div class="col-sm-12 text-left">
                <table class"table-sm table-condensed">
                    <tbody>
                        <tr>
                            <td>Total Expense Amount :</td>
                            <td class="text-right pl-4">'.$total_amount.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
        $total=$expense->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Expense List',
            'rpt_footer'=>$footer_data,
        ]);
    }
}
