@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Password Reset</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{route('dashboard')}}">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Password Reset</a>
                </li>

            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('passwords.updatepassword',$user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12"> 
                                <label for="">Last Password <span class="text-danger">(If you remember)</span></label>
                                <input type="password" class="form-control" >
                            </div>
                            <div class="col-md-12"> 
                                <label for="">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="col-md-12"> 
                                <label for="">Confirm Password</label>
                                <input type="password" id="confirm_password" class="form-control" required>
                            </div><br>
                            <div class="col-md-12">
                                <center>
                                    <button type="submit" class="btn btn-success btn-sm">Update Password</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('Scripts')
<script>
   var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
@endsection