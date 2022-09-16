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
                            <label for="dtp-form">Supplier</label>
                            <select name="supp_id" class="form-control form-control-sm mb-2 search-dropdown" required id="supplier_chqinfo">
                            <option value="">--Select Supplier--</option>  
                            <!-- ajax rendring -->
                            </select>
                        </div>
                        <hr>
                        <div class="table-responsive" id="load_cheques">	
                            <h1 class="text-center text-secondary my-5">Select supplier to load the unpaid cheques details.</h1>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form id="clear_cheque">
                            @csrf
                            <div class="row col-12">  
                                <div class="col-md-5">
                                    <input type="hidden" id="info_id" name="info_id">
                                    <input type="hidden" id="supp_id" name="cust_id">
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
                                        <input type="date" class="form-control form-control-sm mb-2 input-full" name="supp_clear_date" required id="supp_clear_date">
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
    document.getElementById("supp_clear_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

   $(document).ready(function(){
    $(document).on('dblclick','#fetch_supplier_cheques tbody tr',function()
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
        $('#supp_id').val(supp_id);
    })
   })
   
    //
    loadsuppliers();
    function loadsuppliers(){
		$.ajax({
			url:'{{route('loadsuppliers')}}',
			method:'get',
			success:function(res)
			{
				var s='<option value="">--Select Supplier--</option>';
            
            for (var i = 0; i < res.length; i++) {
                    s += '<option value="' + res[i].id + '" data-customvalue="'+ res[i].id +'">'+ res[i].supp_name + '</option>';
                    
                }
                $('#supplier_chqinfo').html(s);
			}
		})
	}
    //fetch cheque info
    $('#supplier_chqinfo').on('change',function(){
       fetchcheques(); 
    })
    
    function fetchcheques()
    {
        let supp_id=$('#supplier_chqinfo').val();
        $.ajax({
            url:'{{route('fetchsuppchequeinfo')}}',
            method:'post',
            data:{
                supp_id:supp_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                $('#load_cheques').html(res)
                $('#fetch_supplier_cheques').DataTable({
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
                url:'{{route('clearsuppcheque')}}',
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
                    document.getElementById("supp_clear_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
                }
            }
           })
          }
        })
    })
    
   

</script>
@endsection



