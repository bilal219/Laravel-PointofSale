<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
    public function adduser(Request $request)
    {
        $image_path='';
        if ($request->hasfile('pic'))
        {
            $file = $request->file('pic');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('userpictures/', $filename);
            $image_path =  $filename;  
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cnic = $request->cnic;
        $user->contact = $request->contact;
        $user->role = $request->role;
        $user->pic = $image_path;
        $user->user_status = "Y";
        $user->password = Hash::make($request->password);
        $user->save();
    }
    //fetch Users
    public function fetchusers()
    {
       $user=DB::table('users')
       ->where('user_status','=','Y')
       ->select('users.*')
       ->get();
       $user_data='';
       if($user->count()>0)
       {
           $user_data .='<table id="add-row" class="display table table-striped table-hover">
           <thead>
               <tr>
                   <th>Sr#</th>
                   <th>Name</th>
                   <th>Contact#</th>
                   <th>CNIC#</th>
                   <th>Email</th>
                   <th>Role</th>
                   <th>Actions</th>
               </tr>
           </thead>
           <tbody>';
           foreach($user as $key=>$list)
           {
           $sr=$key+1;
           $user_data .='<tr>
           <td>'.$sr.'</td>
            <td>'.$list->name.'</td>
            <td>'.$list->contact.'</td>
            <td>'.$list->cnic.'</td>
            <td>'.$list->email.'</td>
            <td>'.$list->role.'</td>
            <td>
                <button type="button" id="'.$list->id.'" data-toggle="modal" data-target="#edituserModal" title="" class="btn btn-link btn-primary btn-lg editusericon" data-original-title="Edit Task">
                    <i class="fa fa-edit"></i>
                </button>
                <button type="button" id="'.$list->id.'" data-toggle="tooltip" title="" class="btn btn-link btn-danger btn-lg deleteusericon" data-original-title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </td>
           </tr>';
           }
           $user_data .='</tbody></table>';
           echo $user_data;
       }
       else 
       {
         echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
       }
    }
    //edit users
public function editusers(Request $request)
{
$id=$request->id;
$user=User::find($id);
return response()->json($user);
}
//update Users
public function updateusers(Request $request)
{
  $user=User::find($request->user_id);
  $user_Data=[
      'name'=>$request->name,
      'contact'=>$request->contact,
      'cnic'=>$request->cnic,
      'email'=>$request->email,
      'role'=>$request->role,
  ];
  $user->update($user_Data);
   return response()->json([
       'status'=>200
   ]);
}
public function userdelete(Request $request)
{
  $id=$request->id;
  $user=User::find($id);
  $user_Data=[
      'user_status'=>'N',
  ];
  $user->update($user_Data);
  return response()->json([
      'status'=> 200
  ]);
}
}
