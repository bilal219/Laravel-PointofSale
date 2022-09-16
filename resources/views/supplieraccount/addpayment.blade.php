@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Add Supplier payment</h4>
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
                    <a href="#">Add Supplier payment</a>
                </li>
                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="progress" style="height: 3px;">
				        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			        </div>
                    <div class="card-header">
                        <h4 class="card-title">Add Supplier payment</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills nav-primary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true" onclick="loadsuppliers()">Cash Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false" onclick="loadsuppliers()">Cheque Payment</a>
                            </li>
                        </ul>
                        <hr>
                        <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                <form id="frm_cash_payment">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="customer">Supplier &nbsp;<strong class="text-danger">*</strong></label>
                                        <select name="supplier" id="supplier" required class="form-control form-control-sm search-dropdown">
                                           <!-- rendring -->
                                        </select>
                                    </div>
                                   <label for="amount">Amount &nbsp;<strong class="text-danger">*</strong></label>
                                   <input type="number" class="form-control form-control-sm mb-2" name="amount" required id="amount">
                                   <label for="date">Date &nbsp;<strong class="text-danger">*</strong></label>
                                   <input type="date" class="form-control form-control-sm mb-2" name="supp_acc_date" required id="supp_acc_date">
                                   <label for="pay_type">Type &nbsp;<strong class="text-danger">*</strong></label>
                                    <select name="pay_type" id="pay_type" class="form-control form-control-sm mb-2" required>
                                        <option value="received_in_company">Received in Company</option>
                                        <option value="paid_by_company">Paid by Company</option>
                                    </select>
                                    <button class="btn btn-xs btn-success pull-right mt-2" type="submit" id="cashpay"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Submit</button>
                                </form>    
                            </div>
                            <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                                <form id="frm_cheque_paymant">
                                    @csrf
                                    <label for="amount">Cheque Number &nbsp;<strong class="text-danger">*</strong></label>
                                    <input type="number" class="form-control form-control-sm mb-2" name="chq_number" required id="chq_number">
                                    <label for="amount">Amount &nbsp;<strong class="text-danger">*</strong></label>
                                    <input type="number" class="form-control form-control-sm mb-2" required name="amount" id="amount">
                                    <div class="mb-2">
                                        <label for="customer">Supplier &nbsp;<strong class="text-danger">*</strong></label><br>
                                        <select name="supplier" id="chq_supplier" required class="form-control form-control-sm search-dropdown" style="width:100%">
                                          <!-- rendring -->
                                        </select>
                                    </div>
                                    <label for="note">Note &nbsp;<strong class="text-danger">*</strong></label>
                                    <textarea name="note" id="note" cols="3" class="form-control form-control-sm mb-2" required></textarea>
                                    <label for="date">Date &nbsp;<strong class="text-danger">*</strong></label>
                                   <input type="date" class="form-control form-control-sm mb-2" name="supp_chq_date" required id="supp_chq_date">
                                    <label for="pay_type">Type &nbsp;<strong class="text-danger">*</strong></label>
                                    <select name="pay_type" id="pay_type" required class="form-control form-control-sm mb-2">
                                       <option value="paid_by_company">Paid by Company</option>
                                       <option value="received_in_company">Received in Company</option>
                                    </select>
                                    <button class="btn btn-xs btn-success pull-right mt-2" type="submit" id=chkpay><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Submit</button>
                                </form>
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
    loadsuppliers();
    var today = new Date();
    document.getElementById("supp_acc_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);   
    document.getElementById("supp_chq_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);   
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
                $("#chq_supplier").html(s);
			}
		})
	}

    //add payment amount to account
    $('#frm_cash_payment').submit(function(e){
       e.preventDefault();
       const cd=new FormData(this);
       $('#cashpay').prop('disabled',true);
       $.ajax({
            xhr: function() 
            {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            url:'{{route('addsuppcashpayment')}}',
            method:'post',
            data:cd,
            cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
            success:function(res)
            {
                $(".progress-bar").width('0%');
                $('#successsound').trigger('play')

                if(res.status===200)
                {
                    $('#successsound').trigger('play')
                    swal(
                    'Added!',
                    'Payment has been added successfully',
                    'success'
                    )
                    $("#cashpay").prop('disabled', false);
					$('#frm_cash_payment')[0].reset();
                    document.getElementById("supp_acc_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);   
                    $('#pay_receipt').html(res.content);
                    $('#account_payments_modal').modal('show');
                }
            }
       })

    })

    //add cheque payment amount to account
    $('#frm_cheque_paymant').submit(function(e){
       e.preventDefault();
       const cd=new FormData(this);
       $('#chkpay').prop('disabled',true);
       $.ajax({
            xhr: function() 
            {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            url:'{{route('addsuppchqpayment')}}',
            method:'post',
            data:cd,
            cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
            success:function(res)
            {
                $(".progress-bar").width('0%');
                $('#successsound').trigger('play')

                if(res.status===200)
                {
                    $('#successsound').trigger('play')
                    swal(
                    'Added!',
                    'Cheque payment has been added successfully',
                    'success'
                    )
                    $("#chkpay").prop('disabled', false);
					$('#frm_cheque_paymant')[0].reset();
                    document.getElementById("supp_chq_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);   
                    $('#pay_receipt').html(res.content);
                    $('#account_payments_modal').modal('show');
                }
            }
       })

    })
</script>
@endsection



