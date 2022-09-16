@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Customer Receivables</h4>
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
                    <a href="#">Customer Receivables</a>
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
                                    <b class="mb-2"> Customer : </b><br>
                                    <select name="firstfilter" class="tcal form-control form-control-sm search-dropdown" style="width:100%" id="cust_rec" disabled>
                                        <!-- rendering -->
                                        @foreach($cust as $data)
                                        <option value="{{$data->id}}">{{$data->cust_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="col-xl-12 mb-2">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="all_rec" value="all_rec" name="supplieraccount" checked>
                                        <span class="form-radio-sign">All Customer Receivables</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="supplieraccount" id="sngl_rec" value="sngl_rec">
                                        <span class="form-radio-sign">Single Customer Receivables</span>
                                    </label>
                                </div>
                                <hr>   
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_cust_rec">
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
        //fetching and conditions 
        $("input[type='radio']").change(function() {
            if ($(this).val() == "all_rec") 
            {
                $("#cust_rec").prop('disabled', true);
            } 
            else 
            {
                $("#cust_rec").prop('disabled', false);
            }
        }); 
    })
</script>
@endsection