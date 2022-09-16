<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    //index employee
    public function index(){
        return view('Employees.index');
    }
    //add employee

    public function addemployee(Request $request){
        $emptype="";
        $fileName="";
        $file=$request->file('employeeimg');
        if($file)
        {
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/employee_images',$fileName);
        }
        $check=$request->emp_type;
        if($check=="other")
        {
            $emptype=$request->employeetype;
        }
        else{
            $emptype=$check;
        }
        $employee=new Employee;
        $employee->emp_name=$request->emp_name;
        $employee->address=$request->address;
        $employee->contact=$request->contact;
        $employee->cnic=$request->cnic;
        $employee->email=$request->email;
        $employee->status='Y';
        $employee->emp_image=$fileName;
        $employee->emp_type=$emptype;
        $employee->save();
        return response()->json([
           'status'=>200
       ]);
    }

    //fetchemployeedata
    public function fetchemployeedata()
    {
        $emp=Employee::where('status','=','Y')->get();
        $output='';
        if($emp->count()>0)
        {
            $output .='<table id="fetch-employee" class="display table-sm table-striped table-hover" style="width:100%">
            <thead>
            <tr>
              <th>Sr#</th>
              <th>Image</th>
              <th>Name</th>
              <th>E-mail</th>
              <th>Contact</th>
              <th>Action</th>  
            </tr>
          </thead>
          <tbody>';
          foreach($emp as $key=> $employeedata)
          {  $sr=$key+1;
            $image_path="/user.webp";
            if($employeedata->emp_image)
            {
                $image_path="storage/images/employee_images/$employeedata->emp_image";
            }
            $output .='
            <tr>
                <td>'.$sr.'</td>
                <td><div class="avatar avatar-xs"><img src="'.$image_path.'" class="avatar-img rounded-circle"/></div></td>
                <td>'.$employeedata->emp_name.'</td>
                <td>'.$employeedata->email.'</td>
                <td>'.$employeedata->contact.'</td>
                <td>
                    <a href="#" id="'.$employeedata->id.'" data-toggle="modal" data-target="#editemployeeModal" title="" class="fa fa-edit text-primary mr-1 editemployeeicon" data-original-title="Edit Task">
                    </a>
                    <a href="#" id="'.$employeedata->id.'" data-toggle="tooltip" title="" class="fa fa-times text-danger ml-1 deleteemployeeicon" data-original-title="Remove">
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
    //edit Employee

    public function editemployee(Request $request){
        $id=$request->id;
        $emp=Employee::find($id);
        return response()->json($emp);
    }

    //update employee
    public function updateemployee(request $request)
    {   $emptype="";
        $check=$request->emp_type;
        if($check=="other")
        {
            $emptype=$request->employeetype;
        }
        else{
            $emptype=$check;
        }
        $fileName='';
        $emp=Employee::find($request->emp_id);
        if($request->hasFile('employeeimg'))
        {
            $file=$request->file('employeeimg');
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move('storage/images/employee_images',$fileName);
            if($emp->emp_image)
            {
              unlink("storage/images/employee_images/".$emp->emp_image);
            }
        }
        else
        {
            $fileName=$request->emp_image;
        }
        $empData=[
        'emp_name'=>$request->emp_name,
        'address'=>$request->address,
        'contact'=>$request->contact,
        'cnic'=>$request->cnic,
        'email'=>$request->email,
        'emp_image'=>$fileName,
        'emp_type'=>$emptype,
         ];
        $emp->update($empData);
         return response()->json([
             'status'=>200
         ]);
    }

    //delete employee
    public function employeedelete(Request $request)
    {
        $id=$request->id;
        $emp=Employee::find($id);
        $empData=['status'=>'N'];
        $emp->update($empData);
        return response()->json([
            'status'=> 200
        ]);
    }
    public function emplist(Request $request)
    {
        $employees ='';
        $id1 = '';
        $id12 = '';
        $firstid = '';
        $lastid = '';
        $firstid=Employee::select('id')->where('status','=','Y')->first();
        $lastid=Employee::select('id')->where('status','=','Y')->latest('id')->first();
        $id1 = $request->firstfilter;
        $id2 = $request->lastfilter;
        $employee=Employee::all();
        return view('Employees.emplist',compact('firstid','lastid','employee','employees'));
    }
    public function fetchemployees(Request $request)
    {
        $employees = Employee::where('status','=','Y')
        ->where('id','>=',$request->from)->where('id','<=',$request->to)->get();     
        $output='
        <table class="table-sm table-bordered table-condensed w-100">
            <thead>
                <tr>
                    <td class="text-center"><strong>Sr#</strong></td>
                    <td class="text-center"><strong>Employee</strong></td>
                    <td class="text-center"><strong>Address</strong></td>
                    <td class="text-center"><strong>Contact</strong></td>
                    <td class="text-center"><strong>Email</strong></td>
                    <td class="text-center"><strong>Type</strong></td>
                    <td class="text-center"><strong>Entry date</strong></td>
                </tr>
            </thead>
        <tbody>';
        if($employees->count()>0)
        {
            foreach($employees as $key=> $list)
            {  $sr=$key+1;
                $output .='
                <tr style="padding: 1px;">
                    <td class="text-center" style="padding: 1px;">'.$sr.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_name.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->address.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->contact.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->email.'</td>
                    <td class="text-center" style="padding: 1px;">'.$list->emp_type.'</td>
                    <td class="text-center" style="padding: 1px;">'.Carbon::parse($list->created_at)->format('d-M-Y').'</td>
                </tr>';
            }
        }else{
            $output .='<tr><center>No record present against your search</center></tr>';  
        }
        $output .='</tbody></table>';
        $total=$employees->count();
        return response()->json([
            'output'=>$output,
            'total'=>$total,
            'rpt_name'=>'Employee List'
        ]);
    }
}
