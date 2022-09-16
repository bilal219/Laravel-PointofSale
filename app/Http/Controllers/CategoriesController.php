<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('Categories.index');
    }

    //add categories
    public function addcategory(Request $request)
    {
       $category=[
           'cat_name'=>$request->cat_name,
           'cat_status'=>'Y',
       ];
       Category::create($category);
       return response()->json([
        'status'=>200
    ]);
    }
    //fetch categories
    public function fetchcategories()
    {
       $cat=Category::where('cat_status','=','Y')->get();
       $cat_data='';
       $cat_data .='
       <table id="add-row" class="display table-sm table-striped table-hover w-100">
           <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
        <tbody>';   
        if($cat->count()>0)
        {
           foreach($cat as $key=>$cat_info)
           {
           $sr=$key+1;
           $cat_data .='<tr>
           <td>'.$sr.'</td>
            <td>'.$cat_info->cat_name.'</td>
            <td>
                <a href="#" id="'.$cat_info->id.'" data-toggle="modal" data-target="#editCategoriesModal" title="" class="fa fa-edit text-primary mr-1 editcategoryicon" data-original-title="Edit Task">
                </a>
                <a href="#" id="'.$cat_info->id.'" data-toggle="tooltip" title="" class="fa fa-times text-danger ml-1 deletecategoryicon" data-original-title="Remove">
                </a>
            </td>
           </tr>';
           }
        }
        $cat_data .='</tbody></table>';
        echo $cat_data;
       
    }

    //edit categories

    public function editcategory(Request $request)
    {
        $id=$request->id;
        $cat=Category::find($id);
        return response()->json($cat);
    }

    //update Category

    public function updatecategory(Request $request)
    {
        $cat=Category::find($request->cat_id);
        $cat_Data=[
            'cat_name'=>$request->cat_name,
        ];
        $cat->update($cat_Data);
         return response()->json([
             'status'=>200
         ]);
    }

    //delete category

    public function catdelete(Request $request)
    {
        $id=$request->id;
        $cat=Category::find($id);
        $cat_Data=[
            'cat_status'=>'N',
        ];
        $cat->update($cat_Data);
        return response()->json([
            'status'=> 200
        ]);
    }
    //fetch vategory
    public function fetchcombocat()
    {
        $cat=Category::where('cat_status','=','Y')->get();
        return response($cat);
    }
    //unique cat
    public function uniquecat(Request $request)
    {
        $unique=Category::select('cat_name')
        ->where('cat_name','=',$request->input_data)
        ->latest('id')->first();
        if($unique){
          return response()->json(400);
        }
        else {
          return response()->json(200);
        }
      
    }
}
