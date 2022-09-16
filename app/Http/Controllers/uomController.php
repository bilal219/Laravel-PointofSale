<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UOM;

class uomController extends Controller
{
    public function index()
    {
        return view('Uoms.index');
    }
    //add uom
 public function adduom(Request $request)
 {
    $uom=[
        'uom_name'=>$request->uom_name,
        'uom_status'=>'Y',
    ];
     UOM::create($uom);
    return response()->json([
     'status'=>200
 ]);
 }
 //fetch uoms
 public function fetchuoms()
 {
    $uom=UOM::where('uom_status','=','Y')->get();
    $uom_data='';
    if($uom->count()>0)
    {
        $uom_data .='<table id="add-uom" class="display table-sm w-100 table-striped table-hover">
        <thead>
            <tr>
                <th>Sr#</th>
                <th>UOM Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';   
        foreach($uom as $key=>$uom_info)
        {
        $sr=$key+1;
        $uom_data .='
        <tr>
            <td>'.$sr.'</td>
            <td>'.$uom_info->uom_name.'</td>
            <td>
                <a href="#" id="'.$uom_info->id.'" data-toggle="modal" data-target="#edituomModal" title="" class="fa fa-edit text-primary mr-1 edituomicon" data-original-title="Edit Task">
                </a>
                <a href="#" id="'.$uom_info->id.'" data-toggle="tooltip" title="" class="fa fa-times text-danger ml-1 deleteuomicon" data-original-title="Remove">
                </a>
            </td>
        </tr>';
        }
        $uom_data .='</tbody></table>';
        echo $uom_data;
    }
    else 
    {
      echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
    }
 }

 //edit uoms

 public function edituom(Request $request)
 {
     $id=$request->id;
     $uom=UOM::find($id);
     return response()->json($uom);
 }

 //update Category

 public function updateuom(Request $request)
 {
     $uom=UOM::find($request->uom_id);
     $uom_Data=[
         'uom_name'=>$request->uom_name,
     ];
     $uom->update($uom_Data);
      return response()->json([
          'status'=>200
      ]);
 }

 //delete uom

 public function uomdelete(Request $request)
 {
     $id=$request->id;
     $uom=UOM::find($id);
     $uom_Data=[
        'uom_status'=>'N',
    ];
    $uom->update($uom_Data);
     return response()->json([
         'status'=> 200
     ]);
 }
 //combobox data
 public function fetchcombouom()
 {
    $uom=UOM::where('uom_status','=','Y')->get();
    return response($uom);
 }

  //unique uom
  public function uniqueuom(Request $request)
  {
      $unique=UOM::select('uom_name')
      ->where('uom_name','=',$request->input_data)
      ->latest('id')->first();
      if($unique){
        return response()->json(400);
      }
      else {
        return response()->json(200);
      }
    
  }

}
