@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Supplier Account</h4>
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
                    <a href="#">Supplier Account</a>
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
                                    <h4 for="inlineinput" class="card-title mr-3">Supplier Account</h4>
                                </div>    
                            </div>
                        </form>
                    </div>
                    <div class="card-body">   
                        <div class="col row">
                            <ul class="nav nav-pills nav-primary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Single Supplier</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false">All Suppliers</a>
                                </li>
                            </ul>
                            <div class="ml-auto" id="filters">
                                <form id="date_filter">
                                    @csrf
                                    <div class="row">
                                        <div class="mr-3">
                                        <label for="dtp-form">Supplier</label><br>
                                            <select name="supplier_id" class="form-control form-control-sm mb-2 search-dropdown" required id="supplier">
                                            <option value="">--Select Supplier--</option>  
                                            <!-- ajax rendring -->
                                            </select>
                                        </div>
                                        <div class="">
                                            <div class="d-flex">
                                                <div class="mx-1">
                                                    <label for="dtp-form">From :</label>
                                                    <input type="date" name="dtp_from" id="dtp-from" required class="form-control form-control-sm" onchange="daterange()">
                                                </div>
                                                <div class="mx-1">
                                                    <label for="dtp-to">To :</label>
                                                    <input type="date" name="dtp_to" id="dtp-to" required class="form-control form-control-sm">
                                                </div>
                                                <button type="submit" class="btn btn-icon btn-link mt-3">
                                                    <i class="fa fa-search"></i>
                                                </button>           
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                <div class="table-responsive" id="single_supplier_account">	
                                     <h1 class="text-center text-secondary my-5">Select supplier to load the account details.</h1>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                                <div class="table-responsive" id="all_supplier_account">	
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

<!-- cheque clearance modal -->

<div class="modal fade bd-example-modal-lg" id="chequeclearancemodal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" id="cat_modal" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cheque Clearance</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
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
                <hr>
				<p class="small text-danger">Fields name with * are mendatory</p>
				<form method="POST" id="clear_cheque">
				@csrf
				<div class="row col-12">  
                    <div class="col-md-7">
                        <input type="hidden" id="info_id" name="info_id">
                        <input type="hidden" id="supp_id" name="supp_id">
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
                    </div>  
                </div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary btn-sm" id="chkpay"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Clear</button>	
			</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('Scripts')
<script>
    var today = new Date();
    document.getElementById("dtp-from").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    document.getElementById("dtp-to").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    document.getElementById("supp_clear_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
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
                $("#supplier").html(s);
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
        allsupplieraccount();
    })
    
    //all customer accounts
    function allsupplieraccount()
    {
       $.ajax({
        url:'{{route('allsupplieraccount')}}',
        method:'get',
        success:function(res){
           $('#all_supplier_account').html(res);
           $('#fetch-all-supplier-accounts').DataTable({
                "pageLength": 5,
            });
        }
       })
    }
    //load customerdata
    $('#supplier').on('change',function(){
        var supp_id=this.value;
        getsingledata();
        fetchmodalsupplier(supp_id);
    })

    //get data
    function getsingledata()
    {
        var supplier_id=$('#supplier').val();
        $.ajax({
            url:'{{route('singlesupplieraccount')}}',
            method:'post',
            data:{
                supplier_id:supplier_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                $('#single_supplier_account').html(res);
                $('#fetch-supplier-accounts').DataTable({
				       "pageLength": 5,
			     });
            }
        })
    }
    
    $('#date_filter').submit(function(e){
        e.preventDefault();
        const cd=new FormData(this);
        $.ajax({
            url:'{{route('singledatesupplieraccount')}}',
            method:'post',
            data:cd,
            cache:false,
			processData:false,
			contentType:false,
            success:function(res)
            {
                $('#single_supplier_account').html(res);
                $('#fetch-supplier-accounts').DataTable({
				    "pageLength": 5,
			    });
            }
        })
    })


//checkclearance
$(document).ready(function(){
    $(document).on('dblclick','#fetch_supplier_cheques tbody tr',function()
    {
        var chq_number=$(this).find('td:eq(2)').text();
        var chq_amount=$(this).find('td:eq(3)').text();
        var method=$(this).find('td:eq(5)').text();
        var supp_id=$(this).find('td:eq(1)').attr('id');
        var id=$(this).attr('id');
        

        $('#chq_number').val(chq_number);
        $('#chq_amount').val(chq_amount);
        $('#pay_type').val(method);
        $('#info_id').val(id);
        $('#supp_id').val(supp_id);
    })
   })
   

    //
     function fetchmodalsupplier(supp_id)
    {
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
                $('#supplier_chqinfo').val(supp_id);
                fetchcheques();			
            }
		})
    }
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
                xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                    }
                }, false);
                return xhr;
                },
                method:'post',
                url:'{{route('clearsuppcheque')}}',
                data:cd,
                cache:false,
                processData:false,
                contentType:false,
                beforeSend: function(){
                $(".progress-bar").width('0%');
                },
                success:function(res)
                {
                    if(res.status===200)
                    {
                        $(".progress-bar").width('0%');
                        $('#successsound').trigger('play')
                        swal(
                        'Success!',
                        'Check has been cleared successfully.',
                        'success'
                        )
                        fetchcheques();
                        $('#clear_cheque')[0].reset();
                        getsingledata();
                    }
                }
            })
          }
        })
    })

    function printData()
    {
    var divToPrint=document.getElementById("printTable");
    newWin= window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
    }

    $('#button').on('click',function(){
    printData();
    })
</script>
@endsection



