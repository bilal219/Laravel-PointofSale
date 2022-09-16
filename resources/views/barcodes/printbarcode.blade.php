@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Print Barcode</h4>
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
                    <a href="#">Print Barcode</a>
                </li>

            </ul>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                    <div class="container1">
                                        {!!DNS1D::getBarcodeHTML($barcode->UPC_EAN, "C39")!!}
                                        {{$barcode->UPC_EAN}} <br>
                                        {{$barcode->product_name}}
                                    </div>
                                </center><br>
                                <center>
                                    <button class="btn btn-success btn-sm" id="print"><i class="fa fa-print"
                                            aria-hidden="true"></i>
                                        Print</button>
                                </center>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('Scripts')

@endsection