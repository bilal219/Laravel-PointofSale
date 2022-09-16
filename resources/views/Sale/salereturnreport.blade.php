@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Sale Return Report</h4>
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
                    <a href="#">Sale Return Report</a>
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
                                    <b> Product : </b>
                                    <select name="firstfilter" class="tcal form-control form-control-sm select2bs4" id="sale_rtn_prods" disabled>
                                        <!-- rendering -->
                                        @foreach($prod as $data)
                                        <option value="{{$data->id}}">{{$data->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="col-xl-12 mb-2">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="dt_sl_rtn" value="datereturn" name="supplieraccount" checked>
                                        <span class="form-radio-sign">Date Wise Sale Return</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="supplieraccount" id="dt_prd_sl_rtn" value="dt_prod_return">
                                        <span class="form-radio-sign">Date_Product Wise Sale Return</span>
                                    </label>
                                </div>
                                <div class="col-xl-12 mt-3 d-flex">
                                    <div>
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="sl_rtn_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="sl_rtn_to" class="form-control form-control-sm">
                                    </div>          
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="sale_return_report">
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
        document.getElementById("sl_rtn_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("sl_rtn_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("sl_rtn_from").value;
        document.getElementById("sl_rtn_to").min=x;   

        //fetching and conditions 
        $("input[type='radio']").change(function() {
            if ($(this).val() == "datereturn") 
            {
                $("#sale_rtn_prods").prop('disabled', true);
            } 
            else 
            {
                $("#sale_rtn_prods").prop('disabled', false);
            }
        }); 
    })
    function daterange() 
    {
        var x = document.getElementById("sl_rtn_from").value;
        document.getElementById("sl_rtn_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection