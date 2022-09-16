@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Product List</h4>
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
                    <a href="#">Product List</a>
                </li>
            </ul>
        </div>
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <div>
                                <div class="col-md-12 mb-2">
                                    <b> Category : </b>
                                    <select name="firstfilter" class="tcal form-control form-control-sm select2bs4" id="prod_cat_id" disabled>
                                        <!-- rendering -->
                                    </select>
                                </div>
                                <div class="col-xl-12 mt-3">
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" id="all_prods" value="all_prods" name="products" checked>
                                        <span class="form-radio-sign">All Products</span>
                                    </label>
                                    <br>
                                    <label class="form-radio-label">
                                        <input class="form-radio-input" type="radio" name="products" id="cat_prod" value="cat_prods">
                                        <span class="form-radio-sign">Category Wise Products</span>
                                    </label>
                                    <hr>
                                </div>
                            </div>
                            <center>
                                <button class="btn btn-primary btn-sm mt-2" id="print_prod_report">
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
    getcategories();
    $("input[type='radio']").change(function() {
        if ($(this).val() == "all_prods") 
        {
            $("#prod_cat_id").prop('disabled', true);
        } 
        else 
        {
            $("#prod_cat_id").prop('disabled', false);
        }
    });
})
</script>
@endsection