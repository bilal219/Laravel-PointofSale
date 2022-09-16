@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Cheque Clearance</h4>
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
                    <a href="#">Cheque Clearance</a>
                </li>
                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="form-group form-inline mt-2 col-md-4">
                                <h4 for="inlineinput" class="card-title mr-3">Cheque Clearance</h4>
                            </div>    
                        </div>
                    </div>
                    <div class="card-body">   
                        <div class="mr-auto col-3">
                            <label for="dtp-form">Customer</label>
                            <select name="supp_id" class="form-control form-control-sm mb-2 search-dropdown" required id="customer_chqinfo">
                            <option value="">--Select Customer--</option>  
                            <!-- ajax rendring -->
                            </select>
                        </div>
                        <hr>
                        <div class="table-responsive" id="load_cheques">	
                            <h1 class="text-center text-secondary my-5">Select customer to load the unpaid cheques details.</h1>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form id="clear_cheque">
                            @csrf
                            <div class="row col-12">  
                                <div class="col-md-5">
                                    <input type="hidden" id="info_id" name="info_id">
                                    <input type="hidden" id="cust_id" name="cust_id">
                                    <div class="form-inline">
                                        <label for="inlineinput" class="col-md-4" style="display: block;">Cheque Number &nbsp;<strong class="text-danger">*</strong></label>
                                        <div class="col-md-8 p-0">
                                            <input type="text" class="form-control form-control-sm input-full" id="chq_number" placeholder="Enter Input" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <label for="inlineinput" class="col-md-4 col-form-label" style="display: block;">Cheque Amount &nbsp;<strong class="text-danger">*</strong></label>
                                        <div class="col-md-8 p-0">
                                            <input type="text" class="form-control form-control-sm input-full" id="chq_amount" name="amount" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <label for="inlineinput" class="col-md-4 col-form-label" style="display: block;">Clear Date &nbsp;<strong class="text-danger">*</strong></label>
                                        <div class="col-md-8 p-0">
                                        <input type="date" class="form-control form-control-sm mb-2 input-full" name="cust_clear_date" required id="cust_clear_date">
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <label for="inlineinput" class="col-md-4 col-form-label" style="display: block;">Note &nbsp;<strong class="text-danger">*</strong></label>
                                        <div class="col-md-8 p-0">
                                            <textarea type="text" class="form-control form-control-sm input-full" id="inlineinput" required placeholder="Note" name="clear_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <small for="inlineinput" class="col-md-4 col-form-label" style="display: block;">Type &nbsp;<strong class="text-danger">*</strong></small>
                                        <div class="col-md-8 p-0">
                                            <select name="pay_type" id="pay_type" required class="form-control form-control-sm input-full">
                                            <option value="paid_by_company">Paid by Company</option>
                                            <option value="received_in_company">Received in Company</option>
                                            </select>         
                                        </div>
                                    </div>
                                    <button class="btn btn-xs btn-primary pull-right mt-2" type="submit" id=chkpay><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Clear</button>
                                </div>  
                            </div>
                        </form>
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
    document.getElementById("cust_clear_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);         
    //getting value
   $(document).ready(function(){

    $(document).on('dblclick','#fetch_customer_cheques tbody tr',function()
    {
        var chq_number=$(this).find('td:eq(2)').text();
        var chq_amount=$(this).find('td:eq(3)').text();
        var method=$(this).find('td:eq(5)').text();
        var cust_id=$(this).find('td:eq(1)').attr('id');
        var id=$(this).attr('id');
        

        $('#chq_number').val(chq_number);
        $('#chq_amount').val(chq_amount);
        $('#pay_type').val(method);
        $('#info_id').val(id);
        $('#cust_id').val(cust_id);
    })
   })
   
    //
    fetchcustomer();
     function fetchcustomer()
    {
        $.ajax({
            url:'{{route('fetchdropcustomer')}}',
            method:'get',
            success:function(res)
            {
              $('#customer_chqinfo').html(res);
            }
        })
    }

    //fetch cheque info
    $('#customer_chqinfo').on('change',function(){
       fetchcheques(); 
    })
    
    function fetchcheques()
    {
        let cust_id=$('#customer_chqinfo').val();
        $.ajax({
            url:'{{route('fetchchequeinfo')}}',
            method:'post',
            data:{
                cust_id:cust_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                $('#load_cheques').html(res)
                $('#fetch_customer_cheques').DataTable({
                    "pageLength": 5,
                });
            }
        })
    }
    //clear cheque
    $('#clear_cheque').submit(function(e){
        e.preventDefault();
        const cd=new FormData(this);
        swal({
		icon : "info",
		title: 'Are you sure?',
		text: "Do you really want to clear this cheque!",
		type: 'warning',
		buttons:{
			confirm: {
				text : 'Yes',
				className : 'btn btn-success'
			},cancel: {
				visible: true,
				className: 'btn btn-danger'
			},
		}
        }).then((clear) => {
          if (clear) {
           $.ajax({
                method:'post',
                url:'{{route('clearcheque')}}',
                data:cd,
                cache:false,
                processData:false,
                contentType:false,
                success:function(res)
                {
                if(res.status===200)
                {
                    $('#successsound').trigger('play')
                    swal(
                    'Success!',
                    'Check has been cleared successfully.',
                    'success'
                    )
                    fetchcheques();
                    $('#clear_cheque')[0].reset();
                }
            }
           })
          }
        })
    })
    
   

</script>

@endsection



