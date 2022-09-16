@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Supplier Customer Account</h4>
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
                    <a href="#">Supplier Customer Account</a>
                </li>
                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form id="customer_account">
                            <div class="row align-items-center">
                                <div class="form-group form-inline mt-2 col-md-4">
                                    <h4 for="inlineinput" class="card-title mr-3">Supplier / Customer Account</h4>
                                </div>    
                            </div>
                        </form>
                    </div>
                    <div class="card-body">   
                        <div class="col row">
                            <ul class="nav nav-pills nav-primary nav-pills-no-bd mb-2" id="pills-tab-without-border" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Single Person</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false">All Persons</a>
                                </li> -->
                            </ul>
                            <div class="ml-auto" id="filters">
                                <form id="form_single_combine">
                                    @csrf
                                    <div class="row">
                                        <div class="mr-3">
                                            <label for="dtp-form">Supplier / Customer</label><br>
                                            <select name="customer_id" class="form-control form-control-sm mb-2 search-dropdown" required id="combine">
                                            <option value="">--Select Name--</option>  
                                            <!-- ajax rendring -->
                                            </select>
                                        </div>
                                        <div>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="dtp-form">From :</label>
                                                    <input type="date" name="dtp_from" id="dtp-from" required class="form-control form-control-sm" onchange="daterange()">
                                                </div>
                                                <div class="d-flex col">
                                                    <div>
                                                        <label for="dtp-to">To :</label>
                                                        <input type="date" name="dtp_to" id="dtp-to" required class="form-control form-control-sm">
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-icon btn-sm btn-link mt-4">
                                                            <i class="fa fa-search"></i>
                                                        </button>               
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                <div class="table-responsive" id="single_combine_account">	
                                     <h1 class="text-center text-secondary my-5">Select supplier / customer to load the account details.</h1>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                                <div class="table-responsive" id="all_customer_account">	
                                    <h1 class="text-center text-secondary my-5">Loading...</h1>
                                </div>
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
<script>
    var today = new Date();
    document.getElementById("dtp-from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    document.getElementById("dtp-to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    document.getElementById("dtp-to").min = document.getElementById("dtp-to").value;
    function daterange() 
    {
        var x = document.getElementById("dtp-from").value;
        document.getElementById("dtp-to").min=x;
        //document.getElementById("dtp-to").value=x;
    }

    $(document).ready(function(){
        loadsuppliers();
    })
   //load supplier
	function loadsuppliers(){
		$.ajax({
			url:'{{route('loadcombine')}}',
			method:'get',
			success:function(res)
			{
				var s='<option value="">--Select Name--</option>';
            
            for (var i = 0; i < res.length; i++) {
                    s += '<option value="' + res[i].id + '" data-customvalue="'+ res[i].id +'">'+ res[i].cust_name + '</option>';
                    
                }
                $("#combine").html(s);
			}
		})
	}
    
    //single customer button click
    $('#pills-home-tab-nobd').on('click',function(){
        $('#filters').fadeIn();
    })
    //all customer click
    $('#pills-profile-tab-nobd').on('click',function(){
        $('#filters').fadeOut();
    })

    function allcombineaccount(){
    
    }

    $(document).on('change','#combine',function(e){
      e.preventDefault();
      $.ajax({
        url:'{{route('singlecombineaccount')}}',
        method:'post',
        data:{
            cust_id:$(this).val(),
            _token:'{{csrf_token()}}',
        },
        success:function(res){
            $('#single_combine_account').html(res)
            $('#single_combine').DataTable({
                "pageLength": 5,
            });
        }
      })
    })
    //single date combine account
    $('#form_single_combine').submit(function(e){
       e.preventDefault();
       $.ajax({
        url:'singledatecombineaccount',
        method:'post',
        data:{
            from:$('#dtp-from').val(),
            to:$('#dtp-to').val(),
            cust_id:$('#combine').val(),
            _token:'{{csrf_token()}}',
        },
        success:function(res){
            $('#single_combine_account').html(res)
            $('#single_combine').DataTable({
                "pageLength": 5,
            });
        }

       })   
     })
    </script>
@endsection



