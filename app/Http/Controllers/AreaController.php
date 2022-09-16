<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    // area index page
    public function index()
    {
        return view('Area.index');
    }
    //add area
    public function addarea(Request $request){
        $area=[
            'area'=>$request->area_name,
            'area_status'=>'Y',
        ];
        Area::create($area);
        return response()->json([
         'status'=>200
     ]);
    }
    //fetch areas

    public function fetchareas(){
        $area=Area::where('area_status','=','Y')->get();
        $area_data='';
        if($area->count()>0)
        {
            $area_data .='<table id="add-area" class="display table table-striped table-hover">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Area Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';   
            foreach($area as $key=>$area_info)
            {
            $sr=$key+1;
            $area_data .='<tr>
            <td>'.$sr.'</td>
             <td>'.$area_info->area.'</td>
             <td>
                 <button type="button" id="'.$area_info->id.'" data-toggle="modal" data-target="#editareaModal" title="" class="btn btn-link btn-primary btn-lg editareaicon" data-original-title="Edit Task">
                     <i class="fa fa-edit"></i>
                 </button>
                 <button type="button" id="'.$area_info->id.'" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-lg deleteareaicon" data-original-title="Remove">
                     <i class="fa fa-times"></i>
                 </button>
             </td>
            </tr>';
            }
            $area_data .='</tbody></table>';
            echo $area_data;
        }
        else 
        {
          echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
     }
    //editarea
    public function editarea(Request $request){
        $id=$request->id;
        $area=Area::find($id);
        return response()->json($area);
    }
    //update area
    public function updatearea(Request $request){
        $area=Area::find($request->area_id);
        $area_Data=[
            'area'=>$request->area_name,
        ];
        $area->update($area_Data);
         return response()->json([
             'status'=>200
         ]);
    }
    //deletrearea
    public function areadelete(Request $request){
        $id=$request->id;
        $area=Area::find($id);
        $area_Data=[
            'area_status'=>'N',
        ];
        $area->update($area_Data);
        return response()->json([
            'status'=> 200
        ]);
    }
    //for dropdowns

    public function fetchareadata()
    {
        $area=Area::where('area_status','=','Y')->get();
        return response($area);   
    }

}
