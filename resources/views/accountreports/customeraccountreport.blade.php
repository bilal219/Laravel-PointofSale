@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Customer Account</h4>
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
                    <a href="#">Customer Account</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <div>
                                <div class="col-xl-12 mb-2 d-flex">
                                    <div class="mr-1">
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="cust_acc_dtp_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="cust_acc_dtp_to" class="form-control form-control-sm">
                                    </div>          
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <b class="mb-2"> Customer : </b><br>
                                    <select name="firstfilter" class="form-control form-control-sm search-dropdown" id="cust_acc_id" style="width:100%" disabled>
                                        <!-- rendering -->
                                    </select>
                                </div>
                                <div class="col-xl-12 mt-3">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="all_cust" value="all_cust" name="customeraccount" checked>
                                        <span class="form-radio-sign">All Customer</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="customeraccount" id="sngl_cust" value="sngl_cust">
                                        <span class="form-radio-sign">Single Customer</span>
                                    </label>
                                    <hr>
                                </div>
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_cust_acc_report">
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
        document.getElementById("cust_acc_dtp_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("cust_acc_dtp_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("cust_acc_dtp_from").value;
        document.getElementById("cust_acc_dtp_to").min=x;
        
        //fetching and conditions 
        getcustomers()
        $("input[type='radio']").change(function() {
            if ($(this).val() == "all_cust") 
            {
                $("#cust_acc_id").prop('disabled', true);
            } 
            else 
            {
                $("#cust_acc_id").prop('disabled', false);
            }
        });
    })
    function daterange() 
    {
        var x = document.getElementById("cust_acc_dtp_from").value;
        document.getElementById("cust_acc_dtp_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection