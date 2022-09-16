@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">All User Sales</h4>
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
                    <a href="#">All User Sales</a>
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
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="sale" value="sale" name="supplieraccount" checked>
                                        <span class="form-radio-sign">Sale</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="supplieraccount" id="sale_detail" value="sale_detail">
                                        <span class="form-radio-sign">Sale Detail</span>
                                    </label>
                                </div>
                                <div class="col-xl-12 mt-3 d-flex">
                                    <div class="mr-1">
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="sale_dtp_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="sale_dtp_to" class="form-control form-control-sm">
                                    </div>          
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_all_user_sale_report">
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
        document.getElementById("sale_dtp_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("sale_dtp_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("sale_dtp_from").value;
        document.getElementById("sale_dtp_to").min=x;    
    })
    function daterange() 
    {
        var x = document.getElementById("sale_dtp_from").value;
        document.getElementById("sale_dtp_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection