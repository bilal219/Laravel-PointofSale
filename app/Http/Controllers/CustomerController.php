<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supplier;
use Carbon\Carbon;
use DB;

class CustomerController extends Controller
{
    //index employee
    public function index(){
        return view('Customers.index');
    }
    public function custlist(Request $request)
    {
        $customers ='';
        $id1 = '';
        $id12 = '';
        $firstid = '';
        $lastid = '';
        $firstid=Customer::select('id')->where('status','=','Y')->first();
        $lastid=Customer::select('id')->where('status','=','Y')->latest()->first();
        $id1 = $request->firstfilter;
        $id2 = $request->lastfilter;
        $customer=Customer::all();
        return view('Customers.custlist',compact('firstid','lastid','customer','customers'));
    }
    public function fetchcustList(Request $request)
    {
        $customers = Customer::where('status','=','Y')
        ->where('id','>=',$request->from)->where('id','<=',$request->to)->get();     
        $output='<table class="table-sm table-bordered table-condensed" style="width:100%">
        <thead>
            <tr>
                <td class="text-center"><strong>Sr#</strong></td>
                <td class="text-center"><strong>Customer</strong></td>
                <td class="text-center"><strong>Address</strong></td>
                <td class="text-center"><strong>Contact</strong></td>
                <td class="text-center"><strong>Email</strong></td>
                <td class="text-center"><strong>Entry date</strong></td>
            </tr>
        </thead>
        <tbody>';
        if($customers->count()>0)
        {
            foreach($customers as $key=> $list)
            {  $sr=$key+1;
                $output .='<tr style="padding: 1px;">
                <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                <td class="text-center" style="padding: 1px;">'.$list->cust_name.'</td>
                <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                <td class="text-center" style="padding: 1px;">'.$list->cnic.'</td>
                <td class="text-center" style="padding: 1px;">'.$list->email.'</td>
                <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><center>No record present against your search</center></tr>';  
        }
        $output .='</tbody></table>';
        $total=$customers->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Customer List'
        ]);
        
    }
    //add customer

    public function addcustomer(Request $request){
        $fileName='';
        $file=$request->file('cust_image');
        if($file){
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/cust_supplier_images/',$fileName);
        }
        $custData=[
            'cust_name'=>$request->cust_name,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'cnic'=>$request->cnic,
            'email'=>$request->email,
            'cust_image'=>$fileName,
            'fathername'=>$request->fathername,
            'area_id'=>$request->cust_area,
            'status'=>'Y',
            'type_id'=>$request->cust_type
        ];
        Customer::create($custData);
        
        return response()->json([
           'status'=>200
       ]);
  
    }

    //fetchcustomerdata
    public function fetchcustomersdata()
    {
        $cust=DB::table('customers')
        ->select('customers.id','customers.cust_image', 'customers.cust_name', 'customers.contact', 'types.type', 'areas.area')
        ->leftJoin('types','types.id','=','customers.type_id')
        ->leftJoin('areas','areas.id','=','customers.area_id')
        ->where('customers.status','=','Y')
        ->get();
        $output='';
        if($cust->count()>0)
        {
            $output .='<table id="fetch-customer" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
            <tr>
              <th>Sr#</th>
              <th>Image</th>
              <th>Customer Name</th>
              <th>Type</th>
              <th>Contact</th>
              <th>Area</th>
              <th>Action</th>  
            </tr>
          </thead>
          <tbody>';
          foreach($cust as $key=> $custdata)
          {  $sr=$key+1;
             $src="/user.webp";
             if($custdata->cust_image)
             {
                $src="storage/images/cust_supplier_images/$custdata->cust_image";
             }
              $output .='<tr>
              <td>'.$sr.'</td>
              
              <td><div class="avatar avatar-xs"><img src='.$src.' class="avatar-img rounded-circle"/></div></td>

              <td>'.$custdata->cust_name.'</td>
              <td>'.$custdata->type.'</td>
              <td>'.$custdata->contact.'</td>
              <td>'.$custdata->area.'</td>
              <td>
                    <a href="#" id="'.$custdata->id.'" data-toggle="modal" data-target="#editcustomerModal" title="" class="fa fa-edit text-primary mr-1 editcustomericon" data-original-title="Edit Task">
                    </a>
                    <a href="#" id="'.$custdata->id.'" data-toggle="tooltip" title="" class="fa fa-times text-danger ml-1 deletecustomericon" data-original-title="Remove">
                    </a>
               </td>
             
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
    //edit Customer

    public function editcustomer(Request $request){
        $id=$request->id;
        $cust=Customer::find($id);
        return response()->json($cust);
    }

    //update employee
    public function updatecustomer(request $request) 
    {   
        $cust=Customer::find($request->cust_id);
        $supp=Supplier::where('id','=',$cust->supp_id)->first();
        if($request->hasFile('cust_image'))
        {
            $file=$request->file('cust_image');
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/cust_supplier_images/',$fileName);
            if($cust->cust_image)
            {
              unlink('storage/images/cust_supplier_images/'.$cust->cust_image);
            }
        }
        else
        {
            $fileName=$cust->cust_image;
        }
        $custData=[
            'cust_name'=>$request->cust_name,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'cnic'=>$request->cnic,
            'email'=>$request->email,
            'cust_image'=>$fileName,
            'fathername'=>$request->fathername,
            'area_id'=>$request->cust_area,
            'status'=>'Y',
            'type_id'=>$request->cust_type
         ];
         if($supp)
        {
            $suppData=
            [
                'supp_name'=>$request->cust_name,
                'address'=>$request->address,
                'contact'=>$request->contact,
                'email'=>$request->email,
                'supp_image'=>$fileName,
                'area'=>$request->cust_area,
                
            ];
            $supp->update($suppData);
        }
        $cust->update($custData);
        return response()->json([
            'status'=>200
        ]);
    }

    //delete employee
    public function customerdelete(Request $request)
    {
        $id=$request->id;
        $cust=Customer::find($id);
        $custData=['status'=>'N'];
        $cust->update($custData);
        return response()->json([
            'status'=> 200
        ]);
    }

    //fetch customer for dropdown
    public function fetchdropcustomer()
    {
        $custoutput='';
        $customers=Customer::select('id','cust_name')->where('status','=','Y')->get();
        foreach($customers as $cust_data)
        {$custoutput.='<option value="'.$cust_data->id.'">'.$cust_data->cust_name.'</option>';}
        echo $custoutput;
    }
    //unique name
    public function uniquecustomercnic(Request $request)
    {
      $unique=Customer::select('cnic')
      ->where('cnic','=',$request->input_data)
      ->where('status','=','Y')
      ->latest('id')->first();
      if($unique){
        return response()->json(400);
      }
      else {
        return response()->json(200);
      }
    }
    //unique cust_contact
    public function uniquecustomercontact(Request $request)
    {
      $unique=Customer::select('contact')
      ->where('contact','=',$request->input_data)
      ->latest('id')->first();
      if($unique){
        return response()->json(400);
      }
      else {
        return response()->json(200);
      }
    }
   
}
