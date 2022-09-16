@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Employee List</h4>
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
                    <a href="#">Employee List</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <b> From : </b>
                                    <select name="firstfilter" class="tcal form-control form-control-sm select2bs4" id="firstempid">
                                        <!-- rendering -->
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <b> To: </b>
                                    <select name="lastfilter" class="tcal form-control form-control-sm select2bs4" id="lastempid">
                                        <!-- rendering -->
                                    </select>
                                </div>  
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-4" id="print_emp_report">
                                    <i class="fa fa-file" aria-hidden="true"></i>&nbsp;
                                    Load Report
                                </button>
                            </center>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>
@endsection
@section('Scripts')
<script>
    getempids();
</script>
@endsection