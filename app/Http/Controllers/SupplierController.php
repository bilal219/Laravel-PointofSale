<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Supplier;
use Carbon\Carbon;
use DB;

class SupplierController extends Controller
{
   public function index()
   {
       return view('Supplier.index');
   }
   //add supplier
   public function addsupplier(Request $request)
   {
    $fileName='';
    $check='Y'; 
    if(!$request->alsocust)
    {
       $check='N';
    }
    if($request->file('supp_image'))
    {
        $file=$request->file('supp_image');
        $fileName=time().'.'.$file->getClientOriginalExtension();
        $file->move('storage/images/cust_supplier_images',$fileName);
    }
    $suppData=[
        'supp_name'=>$request->supp_name,
        'company_name'=>$request->comp_name,
        'agancy_name'=>$request->agencyname,
        'address'=>$request->address,
        'contact'=>$request->contact,
        'email'=>$request->email,
        'supp_image'=>$fileName,
        'is_customer'=>$check,
        'area'=>$request->supp_area,
        'status'=>'Y',
    ];
    Supplier::create($suppData);
    $supp=DB::table('suppliers')
    ->select('id')
    ->orderBy('id','desc')
    ->first();
    if($request->alsocust)
    {
        
        $custData=
        [
            'supp_id'=>$supp->id,
            'cust_name'=>$request->supp_name,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'cust_image'=>$fileName,
            'area_id'=>$request->supp_area,
            'status'=>'Y',
        ];
        Customer::create($custData);
    }
    return response()->json([
       'status'=>200
   ]);
   }
   public function fetchsuppliersdata()
    {
        $supp=DB::table('suppliers')
        ->select('suppliers.id','suppliers.supp_image', 'suppliers.supp_name', 'suppliers.company_name', 'suppliers.agancy_name', 'suppliers.contact', 'areas.area')
        ->leftJoin('areas','areas.id','=','suppliers.area')
        ->where('suppliers.status','=','Y')
        ->get();
        $output='';
        if($supp->count()>0)
        {
            $output .='<table id="fetch-supplier" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
            <tr>
              <th>Sr#</th>
              <th>Image</th>
              <th>Name</th>
              <th>Company</th>
              <th>Agency</th>
              <th>Contact</th>
              <th>Area</th>
              <th>Action</th>  
            </tr>
          </thead>
          <tbody>';
          foreach($supp as $key=> $suppdata)
          { 
            $sr=$key+1;
            $src="/user.webp";
            if($suppdata->supp_image)
            {
                $src="storage/images/cust_supplier_images/$suppdata->supp_image";
            }
            $output .='
            <tr>
                <td>'.$sr.'</td>
                <td><div class="avatar avatar-xs"><img src='.$src.' class="avatar-img rounded-circle"/></div></td>
                <td>'.$suppdata->supp_name.'</td>
                <td>'.$suppdata->company_name.'</td>
                <td>'.$suppdata->agancy_name.'</td>
                <td>'.$suppdata->contact.'</td>
                <td>'.$suppdata->area.'</td>
                <td>
                    <a href="#"id="'.$suppdata->id.'" data-toggle="modal" data-target="#editsupplierModal" title="" class="text-primary fa fa-edit mr-1 editsuppliericon" data-original-title="Edit Task">
                        
                    </a>
                    <a href="#"id="'.$suppdata->id.'" data-toggle="tooltip" title="" class="text-danger fa fa-times ml-1 deletesuppliericon" data-original-title="Remove">
                       
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
    public function editsupplier(Request $request){
        $id=$request->id;
        $supp=Supplier::find($id);
        return response()->json($supp);
    }

    public function updatesupplier(Request $request)
    {
        
        $check='Y';
        if(!$request->alsocust)
        {
            $check='N';
        }
        $fileName='';
        $supp=Supplier::find($request->supp_id);
        if($request->hasFile('supp_image'))
        {
            $file=$request->file('supp_image');
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/cust_supplier_images/',$fileName);
            if($supp->supp_image)
            {
              unlink('storage/images/cust_supplier_images/'.$supp->supp_image);
            }
        }
        else
        {
            $fileName=$supp->supp_image;
        }
        //update supplier
        $suppData=
        [
            'supp_name'=>$request->supp_name,
            'company_name'=>$request->comp_name,
            'agancy_name'=>$request->agencyname,
            'address'=>$request->address,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'supp_image'=>$fileName,
            'is_customer'=>$check,
            'area'=>$request->supp_area,
            'status'=>'Y',
        ];
        $supp->update($suppData);
        $customer = Customer::where('supp_id','=',$request->supp_id)->first();
      if(!$request->alsocust)
        {
          if($customer){
            $custData=[
                'status'=>'N',
            ];
            $customer->update($custData);
          }
        } 
        else
        {
            $custData=
            [
                'supp_id'=>$supp->id,
                'cust_name'=>$request->supp_name,
                'address'=>$request->address,
                'contact'=>$request->contact,
                'email'=>$request->email,
                'cust_image'=>$fileName,
                'area_id'=>$request->supp_area,
                'status'=>'Y',
            ];
            if($customer){$customer->update($custData);}   
            else{Customer::create($custData);}
        }
        return response()->json([
            'status'=>200
        ]);
    }
    public function supplierdelete(Request $request)
    {
        $id=$request->id;
        $supp=Supplier::find($id);
        $suppData=['status'=>'N'];
        $supp->update($suppData);
        return response()->json([
            'status'=> 200
        ]);
    }

    //fetch suppliers for comboboxes
    public function loadsuppliers()
    {
        $supplier=Supplier::select('id','supp_name')->where('status','=','Y')->get();
        return response()->json($supplier);
    }
    public function suplist(Request $request)
    {
        $suppliers ='';
        $id1 = '';
        $id12 = '';
        $firstid = '';
        $lastid = '';
        $firstid=Supplier::select('id')->where('status','=','Y')->first();
        $lastid=Supplier::select('id')->where('status','=','Y')->latest()->first();
        $id1 = $request->firstfilter;
        $id2 = $request->lastfilter;
        $supplier=Supplier::all();
        return view('Supplier.suplist',compact('firstid','lastid','supplier','suppliers'));
    }
    public function fetchsuppliers(Request $request)
    {
        $suppliers = Supplier::where('status','=','Y')
        ->where('id','>=',$request->from)->where('id','<=',$request->to)->get();     
        $output='<table class="table-sm table-bordered table-condensed w-100">
        <thead>
            <tr>
                <td class="text-center"><strong>Sr#</strong></td>
                <td class="text-center"><strong>Supplier</strong></td>
                <td class="text-center"><strong>Company</strong></td>
                <td class="text-center"><strong>Contact</strong></td>
                <td class="text-center"><strong>Address</strong></td>
                <td class="text-center"><strong>Email</strong></td>
                <td class="text-center"><strong>Entry date</strong></td>
            </tr>
        </thead>
        <tbody>';
        if($suppliers->count()>0)
        {
            foreach($suppliers as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->supp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->company_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->email.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><center>No record present against your search</center></tr>';  
        }
        $output .='</tbody></table>';
        $total=$suppliers->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Supplier List'
        ]);
        
    }
}
