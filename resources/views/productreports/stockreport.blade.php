@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Stock Movement</h4>
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
                    <a href="#">Stock Movement</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                                <div class="col-md-12 mb-2">
                                    <b> Status : </b>
                                    <select name="stock_status" class="form-control form-control-sm mb-2" id="stock_status">
                                        <!-- rendering -->
                                        <option value="Stock In"> Stock In </option>
                                        <option value="Stock Out"> Stock Out </option>
                                    </select>
                                    <div class="d-flex">
                                        <div class="mr-1">
                                            <label for="dtp-form"><b>From :</b></label>
                                            <input type="date" name="dtp-from" id="stock_rpt_dtp_from" class="form-control form-control-sm" onchange="daterange()">
                                        </div>
                                        <div class="ml-auto">
                                            <label for="dtp-to"><b>To :</b></label>
                                            <input type="date" name="dtp-to" id="stock_rpt_dtp_to" class="form-control form-control-sm">
                                        </div>          
                                    </div>
                                    <hr>
                                </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_stockmovement_report">
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
        document.getElementById("stock_rpt_dtp_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("stock_rpt_dtp_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("stock_rpt_dtp_from").value;
        document.getElementById("stock_rpt_dtp_to").min=x;
    })
    function daterange() 
    {
        var x = document.getElementById("stock_rpt_dtp_from").value;
        document.getElementById("stock_rpt_dtp_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection