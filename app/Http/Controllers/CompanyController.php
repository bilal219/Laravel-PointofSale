<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientDetails;
use DB;

class CompanyController extends Controller
{
    public function index()
    {
        $show=true;
        if(ClientDetails::count()>0)
        {
            $show=false;
        }
        return view('companies.index',compact('show'));
    }
    //add company
    public function addcomp(Request $request)
    {
        
        $business=new ClientDetails;
        $business->Bus_Name=$request->comp_name;
        $business->Bus_Name_Ur=$request->comp_urdu_name;
        $business->Bus_Address=$request->comp_address;
        $business->Bus_Address_Ur=$request->comp_urdu_address;
        $business->Bus_Contact1=$request->comp_cont1;
        $business->Bus_Contact2=$request->comp_con2;
        $business->Bus_Contact3=$request->comp_con3;
        $business->Bus_email=$request->comp_email;
        $business->save();
        return response()->json([
        'status'=>200
        ]);
    }
    //fetch Company
    public function fetchcomp()
    {
        $comp=ClientDetails::get();
        $comp_data ='<table id="add-row" class="display table-sm table-striped table-hover w-100">
        <thead>
            <tr>
                <th>Sr#</th>
                <th>Name</th>
                <th>Urdu Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Language</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';
        if($comp->count()>0)
        {
            foreach($comp as $key=>$list)
            {
                $sr=$key+1;
                $comp_data .='<tr id="'.$list->id.'">
                    <td>'.$sr.'</td>
                    <td>'.$list->Bus_Name.'</td>
                    <td>'.$list->Bus_Name_Ur.'</td>
                    <td>'.$list->Bus_Contact1.'</td>
                    <td>'.$list->Bus_email.'</td>
                    <td>'.$list->Bus_Language.'</td>
                    <td>
                        <a href="#" id="'.$list->id.'" data-toggle="modal" data-target="#editcompModal" title="" class="fa fa-edit text-primary mr-1 editcompicon" data-original-title="Edit Task">
                        </a>
                        <a href="#" id="'.$list->id.'" data-toggle="tooltip" title="" class="fa fa-times text-danger ml-1 deletecompicon" data-original-title="Remove">
                        </a>
                    </td>
                </tr>';
            }
        }
        $comp_data .='</tbody></table>';
        echo $comp_data;
    }
    //edit compnay
    public function editcomp(Request $request)
    {
        $id=$request->id;
        $comp=ClientDetails::find($id);
        return response()->json($comp);
    }
    //update Company
    public function updatecomp(Request $request)
    {
        $business=ClientDetails::find($request->comp_id);
        $business->Bus_Name=$request->comp_name;
        $business->Bus_Name_Ur=$request->comp_urdu_name;
        $business->Bus_Address=$request->comp_address;
        $business->Bus_Address_Ur=$request->comp_urdu_address;
        $business->Bus_Contact1=$request->comp_cont1;
        $business->Bus_Contact2=$request->comp_cont2;
        $business->Bus_Contact3=$request->comp_cont3;
        $business->Bus_email=$request->comp_email;
        $business->save();
        return response()->json([
            'status'=>200
        ]);
    }
    //delete
    public function compdelete(Request $request)
    {
        $id=$request->id;
        $comp=ClientDetails::find($id);
        $comp->delete();
        return response()->json([
            'status'=> 200
        ]);
    }
}
