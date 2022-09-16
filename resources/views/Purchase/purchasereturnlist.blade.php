@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Purchase Return List</h4>
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
                    <a href="#">Purchase Return List</a>
                </li> 
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Purchase Return List</h4>
                            <div class="ml-auto">
                                <form id="frm_purchase_return_invoice_list">
                                    <div class="d-flex">
                                        <div class="mx-1">
                                            <label for="dtp-form">From :</label>
                                            <input type="date" name="dtp-from" id="dtp-from" class="form-control form-control-sm" onchange="daterange()">
                                        </div>
                                        <div class="mx-1">
                                            <label for="dtp-to">To :</label>
                                            <input type="date" name="dtp-to" id="dtp-to" class="form-control form-control-sm">
                                        </div>
                                        <button type="submit" class="btn btn-icon btn-link mt-3">
                                            <i class="fa fa-search"></i>
                                        </button>           
                                    </div>
                                </form>
                            </div>
                        </div>                             
                    </div>
                    <div class="card-body">   
                        <div class="table-responsive" id="show_all_purreturnlist">	
                            <h5 class="text-center text-secondary my-5">Loading...</h5>
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
     $(document).ready(function(){
        var today = new Date();
        document.getElementById("dtp-from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("dtp-to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        var x = document.getElementById("dtp-from").value;
        document.getElementById("dtp-to").min=x;
        
        getreturnlist();
    })
    function daterange() 
    {
        var x = document.getElementById("dtp-from").value;
        document.getElementById("dtp-to").min=x;
        //document.getElementById("dtp-to").value=x;
    }

    //fetch table data
    function getreturnlist(){
        let from=$('#dtp-from').val();
        let to=$('#dtp-to').val();
        $.ajax({
            url:'{{route('getpurchasereturnlist')}}',
            method:'post',
            data:{
                from:from,
                to:to,
                _token:'{{csrf_token()}}',
            },
            success:function(res){
                $('#show_all_purreturnlist').html(res);
                $('#PR_lists').DataTable({
                    "pageLength": 5,
                });               
            }
        })
    }

    // dateranger data filteration
    $('#frm_purchase_return_invoice_list').submit(function(e){
        e.preventDefault();
        getreturnlist();
    })

    //show list
    $(document).on('click','.viewPR_detail',function(){
        let invoice_no=$(this).attr('id');
        returnlistdetail(invoice_no)
    })

    // load purchasereturnlist detail
    function returnlistdetail(invoice)
    {
        var invoice_no=invoice
        $.ajax({
            method:'post',
            url:'{{route('purchasereturndetail')}}',
            data:{
                invoice:invoice_no,
                _token:'{{csrf_token()}}',
            },
            success:function(res)
            {
             $('#return_detail_view').html(res);
             $('#return_detail_modal').modal('show');

            }
        })
    }
</script>
@endsection