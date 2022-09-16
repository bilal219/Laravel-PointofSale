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
            <div class="col-md-6">
            <div class="card card-outline">
                    <div class="card-body">

                        <form action="{{route('barcodes.printbarcode')}}" method="get">
                            @csrf
                            <select name="product_id" class="form-control select2bs4" id="selUser" autofocus>
                                <option value="">Search Product</option>
                                @foreach($products as $list)
                                <option value="{{$list->id}}">{{$list->product_name}} | {{$list->UPC_EAN}}</option>
                                @endforeach
                            </select> <br><br>
                            <center>
                                <button type="submit" class="btn btn-success btn-sm">Generate barcode</button>
                            </center>
                        </form>

                    </div>
                </div><!-- /.card -->
            </div>
        </div>
    </div>
</div>



@endsection
@section('Scripts')

@endsection