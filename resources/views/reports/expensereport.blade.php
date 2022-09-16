@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Expense Report</h4>
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
                    <a href="#">Expense Report</a>
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
                                    <b> Category : </b>
                                    <select name="firstfilter" class="tcal form-control form-control-sm select2bs4" id="exp_cat" disabled>
                                        <!-- rendering -->
                                        @foreach($cat as $data)
                                        <option value="{{$data->id}}">{{$data->cat_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="col-xl-12 mb-2">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="all_exp" value="all_exp" name="supplieraccount" checked>
                                        <span class="form-radio-sign">All Expenses</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="supplieraccount" id="cat_exp" value="cat_exp">
                                        <span class="form-radio-sign">Category Wise Expenses</span>
                                    </label>
                                </div>
                                <div class="col-xl-12 mt-3 d-flex">
                                    <div class="mr-1">
                                        <label for="dtp-form"><b>From :</b></label>
                                        <input type="date" name="dtp-from" id="exp_from" class="form-control form-control-sm" onchange="daterange()">
                                    </div>
                                    <div class="ml-auto">
                                        <label for="dtp-to"><b>To :</b></label>
                                        <input type="date" name="dtp-to" id="exp_to" class="form-control form-control-sm">
                                    </div>          
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_exp_report">
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
        document.getElementById("exp_from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("exp_to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("exp_from").value;
        document.getElementById("exp_to").min=x;    
    
        //fetching and conditions 
        $("input[type='radio']").change(function() {
            if ($(this).val() == "all_exp") 
            {
                $("#exp_cat").prop('disabled', true);
            } 
            else 
            {
                $("#exp_cat").prop('disabled', false);
            }
        }); 
    })
    function daterange() 
    {
        var x = document.getElementById("exp_from").value;
        document.getElementById("exp_to").min=x;
        //document.getElementById("dtp-to").value=x;
    }
</script>
@endsection