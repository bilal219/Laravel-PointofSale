@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Cheque List</h4>
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
                    <a href="#">Cheque List</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <div>
                                <div class="col-xl-12 mb-2">
                                    <b> User : </b>
                                    <select name="firstfilter" class="form-control form-control-sm" id="cheque_status">                                       
                                        <option value="Due">Due</option>
                                        <option value="Cleared">Cleared</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="col-xl-12 mb-2">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="chq_customer" value="chq_supplier" checked>
                                        <span class="form-radio-sign">Customer</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="chq_supplier" value="chq_supplier">
                                        <span class="form-radio-sign">Supplier</span>
                                    </label>
                                </div>
                                <div class="col-xl-12 mt-3 d-flex">
                                    <div class="mr-1">
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="chq_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="chq_to" class="form-control form-control-sm">
                                    </div>          
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="chq_list_rpt_btn">
                                    <i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                    Load Report
                                </button>
                            </center>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>
@endsection
@section('Scripts')
<script>
   $(document).ready(function(){
        var today = new Date();
        //date picker
        document.getElementById("chq_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("chq_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("chq_from").value;
        document.getElementById("chq_to").min=x;    
    })
    function daterange() 
    {
        var x = document.getElementById("chq_from").value;
        document.getElementById("chq_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection