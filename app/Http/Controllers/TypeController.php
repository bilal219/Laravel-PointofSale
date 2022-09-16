<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
class TypeController extends Controller
{
     // type index page
     public function index()
     {
         return view('Type.index');
     }
     //add Type
     public function addtype(Request $request){
         $type=[
             'type'=>$request->type_name,
             'type_status'=>'Y',
         ];
         Type::create($type);
         return response()->json([
          'status'=>200
      ]);
     }
     //fetch Types
 
     public function fetchtypes(){
         $type=Type::where('type_status','=','Y')->get();
         $type_data='';
         if($type->count()>0)
         {
             $type_data .='<table id="add-type" class="display table table-striped table-hover">
             <thead>
                 <tr>
                     <th>Sr#</th>
                     <th>Type</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>';   
             foreach($type as $key=>$type_info)
             {
             $sr=$key+1;
             $type_data .='<tr>
             <td>'.$sr.'</td>
              <td>'.$type_info->type.'</td>
              <td>
                  <button type="button" id="'.$type_info->id.'" data-toggle="modal" data-target="#edittypeModal" title="" class="btn btn-link btn-primary btn-lg edittypeicon" data-original-title="Edit Task">
                      <i class="fa fa-edit"></i>
                  </button>
                  <button type="button" id="'.$type_info->id.'" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-lg deletetypeicon" data-original-title="Remove">
                      <i class="fa fa-times"></i>
                  </button>
              </td>
             </tr>';
             }
             $type_data .='</tbody></table>';
             echo $type_data;
         }
         else 
         {
           echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
         }
      }
     //edit type
     public function edittype(Request $request){
         $id=$request->id;
         $type=Type::find($id);
         return response()->json($type);
     }
     //update type
     public function updatetype(Request $request){
         $type=Type::find($request->type_id);
         $type_Data=[
             'type'=>$request->type_name,
         ];
         $type->update($type_Data);
          return response()->json([
              'status'=>200
          ]);
     }
     //delete type
     public function typedelete(Request $request){
         $id=$request->id;
         $type=Type::find($id);
         $type_Data=[
            'type_status'=>'N',
        ];
        $type->update($type_Data);
         return response()->json([
             'status'=> 200
         ]);
     }
    //for dropdown
     public function fetchtypedata()
     {
         $type=Type::where('type_status','=','Y')->get();
        return response($type);
     }
}
