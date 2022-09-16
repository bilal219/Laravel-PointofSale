@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Profit Loss Report</h4>
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
                    <a href="#">Profit Loss Report</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <div>
                                <div class="col-xl-12 mt-3 d-flex">
                                    <div>
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="pft_lss_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="pft_lss_to" class="form-control form-control-sm" onchange="loadprofitloss()">
                                    </div>          
                                </div>
                                <hr>
                                <div class="col-xl-12 mb-2">
                                    <h4 class="mb-1"><b> Sale Profit</b></h4>
                                    <h5 class="mb-2 font-weight-bold" id="sale_profit">0</h5>
                                    <h4 class="mb-1"><b> Total Expences</b></h4>
                                    <h5 class="mb-2 font-weight-bold" id="total_expences">0</h5>
                                    <h4 class="mb-1"><b> Net Profit</b></h4>
                                    <h5 class="mb-2 font-weight-bold" id="net_profit">0</h5>
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="profit_loss_report">
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
        document.getElementById("pft_lss_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("pft_lss_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("pft_lss_from").value;
        document.getElementById("pft_lss_to").min=x;   
    })
    function daterange() 
    {
        var x = document.getElementById("pft_lss_from").value;
        document.getElementById("pft_lss_to").min=x;
        loadprofitloss();
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection