@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Expired Products</h4>
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
                    <a href="#">Expired Products</a>
                </li>        
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Expired Products</h4>
                            <!-- <button class="btn btn-primary btn-round ml-auto" id="addcat" data-toggle="modal" data-target="#addCategoryModal">
                                <i class="fa fa-plus"></i>
                                New Category
                            </button> -->
                            <div class="ml-auto">
                                <label for="product_category">Category :</label>
                                <select name="product_category" class="form-control form-control-sm" id="product_category" onchange="loadexpired()">
                                    <option value="">--Select Category--</option>
                                    @foreach($cat as $cat_data)
                                    <option value="{{$cat_data->id}}">{{$cat_data->cat_name}}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body">   
                        <div class="table-responsive" id="show_all_products">	
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Scripts')
<script>
    loadexpired();
    function loadexpired(){
        var cat_id=$("#product_category").val();
        $.ajax({
            url:'{{route('loadexpired')}}',
            method:'post',
            data:{
               cat_id:cat_id,
               _token:'{{csrf_token()}}'
            },
            success:function(res){
                $('#show_all_products').html(res);
                $('#current_stock').DataTable({
                    "pageLength": 5,
                });
            }
        })
    }
</script>
@endsection