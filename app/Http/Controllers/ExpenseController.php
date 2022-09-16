<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use Carbon\Carbon;
use DB;
class ExpenseController extends Controller
{
    public function index()
    {
        $mytime = Carbon::now()->format('Y-m-d');
        $category = ExpenseCategory::where('status','=','Y')->get();
        return view('expenses.index',compact('category','mytime'));
    }
        //add expense
        public function addexpense(Request $request)
        {
           $expense=[
               'cat_id'=>$request->cat_id,
               'exp_amount'=>$request->exp_amount,
               'exp_addedby'=>$request->exp_addedby,
               'exp_date'=>$request->exp_date,
               'exp_desc'=>$request->exp_desc,
               'exp_status'=>'Y',
           ];
           Expense::create($expense);
           return response()->json([
            'status'=>200
        ]);
        }
                //fetch Expenses
                public function fetchexpenses()
                {
                   $exp=DB::table('expenses')
                   ->join('expense_categories','expense_categories.id','=','expenses.cat_id')
                   ->where('exp_status','=','Y')
                   ->select('expense_categories.cat_name','expenses.*')
                   ->get();
                   $exp_data='';
                   if($exp->count()>0)
                   {
                       $exp_data .='<table id="add-row" class="display table table-striped table-hover">
                       <thead>
                           <tr>
                               <th>Sr#</th>
                               <th>Expense Name</th>
                               <th>Amount</th>
                               <th>Description</th>
                               <th>Expense Added By</th>
                               <th>Expense Date</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>';
                       $total = 0;   
                       foreach($exp as $key=>$list)
                       {
                        $total += $list->exp_amount;
                       $sr=$key+1;
                       $exp_data .='<tr>
                       <td>'.$sr.'</td>
                        <td>'.$list->cat_name.'</td>
                        <td>'.$list->exp_amount.'</td>
                        <td>'.$list->exp_desc.'</td>
                        <td>'.$list->exp_addedby.'</td>
                        <td>'.date('d-m-Y', strtotime($list->exp_date)).'</td>
                        <td>
                            <button type="button" id="'.$list->id.'" data-toggle="modal" data-target="#editExpensesModal" title="" class="btn btn-link btn-primary btn-lg editexpenseicon" data-original-title="Edit Task">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" id="'.$list->id.'" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-lg deleteexpenseicon" data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                       </tr>';
                       }
                       $exp_data .= '<tr>
                       <th>Total</th>
                       <th></th>
                       <th>'.$total.'</th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       </tr>';
                       $exp_data .='</tbody></table>';
                       echo $exp_data;
                   }
                   else 
                   {
                     echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
                   }
                }
                //edit expenses
    public function editexpenses(Request $request)
    {
        $id=$request->id;
        $exp=Expense::find($id);
        return response()->json($exp);
    }
          //update Expenses
          public function updateexpenses(Request $request)
          {
              $exp=Expense::find($request->exp_id);
              $exp_Data=[
                  'cat_id'=>$request->cat_id,
                  'exp_amount'=>$request->exp_amount,
                  'exp_date'=>$request->exp_date,
                  'exp_addedby'=>$request->exp_addedby,
                  'exp_desc'=>$request->exp_desc,
              ];
              $exp->update($exp_Data);
               return response()->json([
                   'status'=>200
               ]);
          }
          public function expdelete(Request $request)
          {
              $id=$request->id;
              $exp=Expense::find($id);
              $exp_Data=[
                  'exp_status'=>'N',
              ];
              $exp->update($exp_Data);
              return response()->json([
                  'status'=> 200
              ]);
          }
}
