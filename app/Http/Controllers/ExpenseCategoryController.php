<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('expensecategories.index');
    }
    //add expense categories
    public function addexpensecategory(Request $request)
    {
       $category=[
           'cat_name'=>$request->cat_name,
           'status'=>'Y',
       ];
       ExpenseCategory::create($category);
       return response()->json([
        'status'=>200
    ]);
    }
        //fetch categories
        public function fetchexpensecategories()
        {
           $cat=ExpenseCategory::where('status','=','Y')->get();
           $cat_data='';
           if($cat->count()>0)
           {
               $cat_data .='<table id="add-row" class="display table table-striped table-hover">
               <thead>
                   <tr>
                       <th>Sr#</th>
                       <th>Category Name</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>';   
               foreach($cat as $key=>$cat_info)
               {
               $sr=$key+1;
               $cat_data .='<tr>
               <td>'.$sr.'</td>
                <td>'.$cat_info->cat_name.'</td>
                <td>
                    <button type="button" id="'.$cat_info->id.'" data-toggle="modal" data-target="#editExpenseCategoriesModal" title="" class="btn btn-link btn-primary btn-lg editcategoryicon" data-original-title="Edit Task">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" id="'.$cat_info->id.'" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-lg deletecategoryicon" data-original-title="Remove">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
               </tr>';
               }
               $cat_data .='</tbody></table>';
               echo $cat_data;
           }
           else 
           {
             echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
           }
        }
    //edit categories
    public function editexpensecategory(Request $request)
    {
        $id=$request->id;
        $cat=ExpenseCategory::find($id);
        return response()->json($cat);
    }
      //update Category

      public function updateexpensecategory(Request $request)
      {
          $cat=ExpenseCategory::find($request->cat_id);
          $cat_Data=[
              'cat_name'=>$request->cat_name,
          ];
          $cat->update($cat_Data);
           return response()->json([
               'status'=>200
           ]);
      }
      //delete category

    public function expcatdelete(Request $request)
    {
        $id=$request->id;
        $cat=ExpenseCategory::find($id);
        $cat_Data=[
            'status'=>'N',
        ];
        $cat->update($cat_Data);
        return response()->json([
            'status'=> 200
        ]);
    }
}
