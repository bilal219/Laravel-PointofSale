<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.partials._head')
        <style>
        .ui-autocomplete {
            z-index: 2147483647;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }
        </style>
    </head>
    <body>
        <div class="wrapper">
                <div class="panel-header bg-primary-gradient">
                    <br>
                    <div class="page-inner pb-5 mt--4">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="text-white pb-2 fw-bold">Technors Point of Sale</h2>
                                <h5 class="text-white op-7 mb-2">Accurate | Reliable | Trusted</h5>
                            </div>
                            <div class="ml-md-auto py-2 py-md-0">

                                <button class="btn btn-default btn-sm mb-2" onclick="myFunction()">
                                    <span class="btn-label">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </span>
                                    Payment
                                </button>|
                                <button class="btn btn-sm mb-2" id="hold_invoice" style="background-color:#D3D3D3">
                                    <span class="btn-label">
                                        <i class="fas fa-pause-circle"></i>
                                    </span>
                                    Hold
                                </button>|
                                <button class="btn btn-sm mb-2" style="background-color:#FFA500" data-toggle="modal"
                                    data-target="#searchinvoicesmodal">
                                    <span class="btn-label">
                                        <i class="fas fa-print"></i>
                                    </span>
                                    View Invoice
                                </button>|
                                <button class="btn btn-sm mb-2" style="background-color:#90ee90" id="btnholdinvoice"
                                    data-toggle="modal" data-target="#hold_invoices_modal">
                                    <span class="btn-label">
                                        <i class="fas fa-file-invoice"></i>
                                    </span>
                                    Hold Invoice
                                </button>|
                                <button class="btn btn-secondary btn-sm mb-2" data-toggle="modal" data-target="#cashregisterclose"
                                    id="cashclosepos">
                                    <span class="btn-label">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                    Cash Register
                                </button>|
                                <button class="btn btn-success btn-sm mb-2" id="refresh">
                                    <span class="btn-label">
                                        <i class="fa fa-redo"></i>
                                    </span>
                                    Refresh
                                </button>|
                                <a href="{{route('dashboard')}}" class="btn btn-danger btn-sm mb-2">
                                    <span class="btn-label">
                                        <i class="fas fa-power-off"></i>
                                    </span>
                                    Close
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">POS</div>
                                        <div class="card-tools">
                                            <label for="title" class="control-block">Invoice# </label>
                                            <input type="text" class="form-control form-control-sm" id="invoice_no" readonly
                                                value="SL-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="posform">
                                        @csrf
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="title" class="control-block">Search Product By
                                                        Name/Barcode
                                                    </label>
                                                    <div class="d-flex form-group">
                                                        <!-- <input list="productlist" required tabIndex="1" autofocus class="form-control form-control-sm" name="product_id" id="search_prod"> -->
                                                        <div class="input-icon" style="width:100%">
                                                            <input type="text" class="form-control form-control-sm" required
                                                                tabindex="1" placeholder="Search Product..." name="search_name"
                                                                id="productlist" autocomplete="off">
                                                            <span class="input-icon-addon">
                                                                <i class="fa fa-search"></i>
                                                            </span>
                                                        </div>
                                                        <!-- <select class="form-control form-control-sm" id="productlist" required name="prod_id" onchange="fetchpro_info()"> -->
                                                        <!-- ajax rendring -->
                                                        <!-- </select> -->
                                                        <button type="button"
                                                            class="mx-1 btn btn-sm btn-success btn-link fa fa-plus"
                                                            data-toggle="modal" data-target="#addproductModal">
                                                        </button>
                                                    </div>
                                                    <!-- <datalist id="productlist">
                                                </datalist> -->
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Product</label>
                                                    <input type="hidden" name="prod_id" id="prod_id">
                                                    <input type="text" id="pro_name" tabindex="2" readonly
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="title" class="control-block">Quantity</label>
                                                    <input type="number" required value="1" min="1" tabindex="3" name="qty"
                                                        class="form-control form-control-sm" id="prd_qty">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="title" class="control-block">Unit Price</label>
                                                    <input required  type="number" id="saleprice" tabindex="4"
                                                        class="form-control form-control-sm" name="unitprice">
                                                </div>

                                                <div class="col-md-2 ">
                                                    <div class="mt-2">
                                                        <input type="submit" style="margin-top:10%" value="Add To Cart"
                                                            tabIndex="5" class="btn btn-success btn-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <table class="table-bordered table-sm table-responsive" id="pos_table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">Item Name</th>
                                                <th style="width:5%">QTY</th>
                                                <th style="width:5%">Unit Price</th>
                                                <th style="width:5%">Discount</th>
                                                <th style="width:5%">Total Price</th>
                                                <th style="width:5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart_tbl">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Customer Information & Checkout</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 row">
                                        <div class="col-xl-4">
                                            <label for="title" class="control-block">Customer</label><br>
                                            <div class="d-flex mb-2">
                                                <select class="form-control form-control-sm search-dropdown" style="width:100%" id="cust_data"
                                                    onchange="fetchcust_info()">
                                                    <!-- ajax rendring -->
                                                </select>
                                                <a href="" id="pos_cust_name"  data-toggle="modal" data-target="#addcustomerModal" class="mx-1 text-success mt-2 fa fa-plus"></a>
                                            </div>
                                            <div class="mb-2 ">
                                                <label for="title" class="control-block">Customer Name</label>
                                                <input readonly type="text" id="cust_name" class="form-control form-control-sm">
                                            </div>
                                            <div class="mb-2">
                                                <label for="title" class="control-block">Contact#</label>
                                                <input readonly type="text" id="cust_contact"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="row">
                                                <label class="control-block mt-2">Order Total</label>&nbsp;&nbsp;&nbsp;
                                                <h3 class="mt-2"><strong id="order_total">00</strong></h3>
                                            </div>
                                            <div class="row">
                                                <label class="control-block mt-2">Previous Balance</label>&nbsp;&nbsp;&nbsp;
                                                <h3 class="mt-2"><strong id="sal_prev_bal">00</strong></h3>
                                            </div>
                                            <div class="row">
                                                <label class="control-block mt-2"><b> Discount </b></label>&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="type" id="cashradio" class="mt-2"
                                                    checked="checked"><span class="mt-2">
                                                    &nbsp;&nbsp;&nbsp;Cash</span>&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="type" id="percentradio" class="mt-2"><span
                                                    class="mt-2">
                                                    &nbsp; &nbsp; &nbsp;Percentage</span>
                                            </div>
                                            <div class="row mt-3">
                                                <input type="number" id="discount_textbox" class="form-control form-control-sm"
                                                    name="" onkeyup="cal_netpayable()">
                                            </div>
                                            <div class="row">
                                                <label class="control-block">Discount Amount</label>&nbsp;&nbsp;&nbsp;
                                                <h3 class="text-info"><strong id="discount_amount">00</strong></h3>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="mb-2">
                                                <label class="control-block">Net Payable</label>&nbsp;&nbsp;&nbsp;
                                                <h3 class="text-info"><strong id="net_payable">00</strong></h3>
                                            </div>
                                            <div class="mb-2">
                                                <label for="title" class="control-block">Payment Amount</label>
                                                <input type="number" id="pyment_amount"
                                                    class="form-control form-control-sm text-danger h3" value="0" min="0"
                                                    name="payment_amount" onkeyup="cal_change()">
                                            </div>
                                            <div class="mb-2">
                                                <label for="title" class="control-block">Change</label>
                                                <input type="number" id="change_amount"
                                                    class="form-control form-control-sm text-primary h3" name="chnage_amount"
                                                    readonly value="0">
                                            </div>
                                            <br>
                                            <button type="submit" id="btn_checkout"
                                                class="btn btn-primary btn-sm btn-block">Complete
                                            </button>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-head-row">

                                        <div class="col-md-12">
                                            <select id="prod_cat" class="form-control form-control-sm" onchange="filterprods()">
                                                <!-- rendering the dropdown -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="prod_data">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- invoice modal -->
                        <div class="modal fade bd-example-modal-lg" id="invoice" tabindex="-1" role="dialog"
                            data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sale Invoice :&nbsp;<small id="inv_no"></small></h5>
                                        <a class="btn btn-light text-capitalize border-0" id="printsalereciptbtn"
                                            data-mdb-ripple-color="dark"><i class="fas fa-print text-primary"></i> Print
                                        </a>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container" id="printinvoice">
                                            <!-- rendring -->
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('layouts.partials._modals')
                    </div>
                    @include('layouts.partials._footer')
                    @include('layouts.partials._footer-script')
                    <script>
                        
                        //  area
                        $("#addareaModal").on('shown.bs.modal', function() {
                            $("#addcustomerModal").css({ opacity: 0.3 });
                            $('#addcustomerModal').css('z-index', 1039);
                            $("#editcustomerModal").css({ opacity: 0.3 });
                            $('#areamodal-footer').addClass('bg-grey2');
                            $('#areamodal-header').addClass('bg-grey2');
                            $('#area_modal').removeClass('modal-lg');
                            $('#area_modal').addClass('modal-dialog-centered');
                            $('input[name=area_name]').focus();
                        });
                        $('#addareaModal').on('hidden.bs.modal', function () {
                        $("#addcustomerModal").css({ opacity: 1 });
                        $("#editcustomerModal").css({ opacity: 1 });
                        $('#addcustomerModal').css('z-index', 1041);
                            $('#modal-footer').removeClass('bg-grey2');
                            $('#modal-header').removeClass('bg-grey2');
                            $('#area_modal').addClass('modal-lg');
                            $('#area_modal').removeClass('modal-dialog-centered');
                        });
                        //type
                        $("#addtypeModal").on('shown.bs.modal', function() {
                            $("#addcustomerModal").css({ opacity: 0.3 });
                            $("#editcustomerModal").css({ opacity: 0.3 });
                            $('#addcustomerModal').css('z-index', 1039);
                            $('#typemodal-footer').addClass('bg-grey2');
                            $('#typemodal-header').addClass('bg-grey2');
                            $('#type_modal').removeClass('modal-lg');
                            $('#type_modal').addClass('modal-dialog-centered');
                            $('input[name=type_name]').focus();
                        });
                        $('#addtypeModal').on('hidden.bs.modal', function () {
                        $("#addcustomerModal").css({ opacity: 1 });
                        $("#editcustomerModal").css({ opacity: 1 });
                        $('#addcustomerModal').css('z-index', 1041);
                            $('#typemodal-footer').removeClass('bg-grey2');
                            $('#typemodal-header').removeClass('bg-grey2');
                            $('#type_modal').addClass('modal-lg');
                            $('#type_modal').removeClass('modal-dialog-centered');
                        });
                        //add Customers
                        $('#add_customer_form').submit(function(e){
                        e.preventDefault();
                        const cd=new FormData(this);
                        $('#add_customer_btn').text('Adding...');
                        $("#add_customer_btn").prop('disabled', true);
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
                            method:'POST',
                            url:'{{route('addcustomer')}}',
                            data:cd,
                            cache:false,
                            processData:false,
                            contentType:false,
                            beforeSend: function(){
                            $(".progress-bar").width('0%');
                            },
                            success:function(res){
                                $(".progress-bar").width('0%');
                                if(res.status===200){
                                    $('#successsound').trigger('play')
                                    swal(
                                    'Added!',
                                    'Customer record has been added successfully',
                                    'success'
                                    )
                                    fetchmodalcustomer();
                                $('#add_customer_btn').text('Add Customer');
                                $("#add_customer_btn").prop('disabled', false);
                                $('#add_customer_form')[0].reset();
                                $('#dvPreview').html("")
                                $('#addcustomerModal').modal('hide');
                            }
                        }

                        })
                        })

                        function fetchmodalcustomer()
                        {
                            $.ajax({
                                url:'{{route('fetchdropcustomer')}}',
                                method:'get',
                                success:function(res)
                                {
                                    $('#cust_data').html(res); 
                                }
                            })
                        }


                        //area modal
                        fillareadd();
                        filltypeadd();
                         //area dropdown fill
                        function fillareadd(){
                            $.ajax({
                            url:'{{route('fetchareadata')}}',
                            method:'get',
                            success:function(res){
                                output='<option value="">--Please select Customer type--</option>';
                                for(i=0;i<res.length;i++){
                                    output +='<option value="'+res[i].id+'">'+res[i].area+'</option>';
                                }
                                    $('#areacombobox').html(output);
                                    $('#editareacombobox').html(output);
                                }
                            })
                        }

                        //type dropdown fill
                        function filltypeadd(){
                        $.ajax({
                                    url:'{{route('fetchtypedata')}}',
                                    method:'get',
                                    success:function(res){
                            output='<option value="">--Please select Customer type--</option>';
                            for(i=0;i<res.length;i++){
                                output +='<option value="'+res[i].id+'">'+res[i].type+'</option>';
                            }
                            $('#typecombobox').html(output);
                            $('#edittypecombobox').html(output);
                        }
                            
                    })
                }
            </script>
            <script language="javascript" type="text/javascript">
$(function () {
    $("#fileupload").change(function () {
        $("#dvPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
           
                if (typeof (FileReader) != "undefined") {
                    $("#dvPreview").show();
                    $("#dvPreview").html("<img />");
                    $("#dvPreview img").addClass('avatar-img rounded');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            
        } else {
            alert("Please upload a valid image file.");
        }
    });
});
</script>
<script language="javascript" type="text/javascript">
$(function () {
    $("#fileeditupload").change(function () {
        $("#dveditPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
           
                if (typeof (FileReader) != "undefined") {
                    $("#dveditPreview").show();
                    $("#dveditPreview").html("<img />");
                    $("#dveditPreview img").addClass('avatar-img rounded');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dveditPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            
        } else {
            alert("Please upload a valid image file.");
        }
    });
});


//add area
$('#add_area_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_area_btn').text('Adding...');
		$("#add_area_btn").prop('disabled', true);
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
			method:'POST',
			url:'{{route('addarea')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
					$(".progress-bar").width('0%');
					if(res.status===200){
						$('#successsound').trigger('play')
						swal(
						'Added!',
						'Area has been added successfully',
						'success'
						)
            fillareadd();
					$('#add_area_btn').text('Add Area');
					$("#add_area_btn").prop('disabled', false);
					$('#add_area_form')[0].reset();
					$('#addareaModal').modal('hide');
					}
					
					}

		})
		})



    //add Type
		$('#add_type_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_Type_btn').text('Adding...');
		$("#add_Type_btn").prop('disabled', true);
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
			method:'POST',
			url:'{{route('addtype')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
					$(".progress-bar").width('0%');
					if(res.status===200){
						$('#successsound').trigger('play')
						swal(
						'Added!',
						'Area has been added successfully',
						'success'
						)
						filltypeadd();
					$('#add_type_btn').text('Add Type');
					$("#add_type_btn").prop('disabled', false);
					$('#add_type_form')[0].reset();
					$('#addtypeModal').modal('hide');
					}
					
					}

		})
		})
$(document).ready(function(){
  var input_id='#cust_cnic';
  var route='uniquecustomercnic';
  var div_id="#div_cust_cnic";
  var message_id="#cust_cnic_message";
  var form_btn_id="#add_customer_btn"
  uniquevalidation(input_id,route,div_id,message_id,form_btn_id);
})

$(document).ready(function(){
  var input_id='#cust_contact';
  var route='uniquecustomercontact';
  var div_id="#div_cust_contact";
  var message_id="#cust_contact_message";
  var form_btn_id="#add_customer_btn"
  uniquevalidation(input_id,route,div_id,message_id,form_btn_id);
})


</script>
<!-- add productmodal -->
<div class="modal fade bd-example-modal-lg" id="addproductModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="small text-danger">Fields Name with * are mendatory</p>
				<form id="add_product_form">
          @csrf
          <div class="row">
              <div class="col-lg">
                  <label for="emp_name">Product Name&nbsp;<strong class="text-danger">*</strong></label>
                  <input type="text" name="product_name" id="prod_name" class="form-control form-control-sm" placeholder="Product Name" required onkeyup="secondName()">
              </div>
              <div class="col-lg">
                  <label for="email">Second Name</label>
                  <input type="text" name="generic_name" class="form-control form-control-sm" id="gen_name" placeholder="Second Name">
              </div>
          </div>
          <div class="my-2 row">
            <div class="col-lg">
              <input type="checkbox" name="autobarcode" checked id="chkbarcode"><small>&nbsp;&nbsp;Generate Auto Barcode&nbsp;<strong class="text-danger">*</strong></small>
              <input type="number" name="upc_ean" class="form-control form-control-sm" required placeholder="Barcode" id="upc_ean">
            </div>
            <div class="col-lg">
              <input type="checkbox" name="apply_expiry"  id="apply_expiry"><small>&nbsp;&nbsp;Apply Expiry&nbsp;<strong class="text-danger">*</strong></small>
              <input type="date" name="expiry_date" class="form-control form-control-sm" required readonly id="expiry_date">
            </div>
          </div>
          <div class="row">
              <div class="col-lg">
                  <label for="squareSelect">Category&nbsp;<strong class="text-danger">*</strong></label>
                  <div class="d-flex">
                      <select class="form-control form-control-sm" id="addCategory" required name="cat_id">
                        <!-- ajax rendering -->
                      </select>                          
                      <a href="" id="addtype"  data-toggle="modal" data-target="#addCategoryModal" class="mx-1 btn btn-success btn-sm btn-link fa fa-plus"></a>
                  </div>                           
              </div>
              <div class="col-lg">
                  <label for="squareSelect">UOM&nbsp;<strong class="text-danger">*</strong></label>
                  <div class="d-flex">
                      <select class="form-control form-control-sm" id="adduom" name="uom_id" required>
                        <!-- ajax rendering -->
                      </select>                           
                      <a href="" id="addarea" data-toggle="modal" data-target="#adduomModal" class="mx-1 btn btn-success btn-sm btn-link fa fa-plus"></a> 
                  </div>                           
              </div>
          </div>
          <input type="checkbox" name="dont_stock_manage" class="my-2" id="stock_manage"><small>&nbsp;&nbsp;Don't Manage Stock</small>
          <div class="row">
            <div class="col-lg my-2">
                <label for="contact">Opening Quantity&nbsp;<strong class="text-danger">*</strong></label>
                <input type="number" name="opening_qty" id="opening_qty" class="form-control form-control-sm" placeholder="Opening Quantity" required>
                <small class="text-danger" id="qty_error_msg"></small>
              </div>
            <div class="col-lg my-2">
                <label for="phone">Cost Price&nbsp;<strong class="text-danger">*</strong></label>
                <input type="text" name="cost_price" class="form-control form-control-sm" id="cost_price" placeholder="Cost price" required>
                <small class="text-danger" id="cost_error_msg"></small>
              </div>
          </div>
          <div class="row">
            <div class="col-lg my-2">
                <label for="contact">Retail Price&nbsp;<strong class="text-danger">*</strong></label>
                <input type="number" name="retail_price" id="retail_price" class="form-control form-control-sm" placeholder="Retail Price" required>
                <small class="text-danger" id="retail_error_msg"></small>
              </div>
            <div class="col-lg my-2">
                <label for="phone">Discount(%)</label>
                <input type="number" name="discount" id="discount" class="form-control form-control-sm" placeholder="Discount(%)">
            </div>
            <div class="col-lg my-2">
                <label for="phone">Final Price</label>
                <input type="number" name="final_price" id="final_price" class="form-control form-control-sm" placeholder="Final price" readonly>
            </div>
          </div>
          <div class="row">
            <div class="col-lg my-2">
                <label for="contact" class="m-1">Re Order Level&nbsp;<strong class="text-danger">*</strong></label>
                <input type="number" name="reorder_qty" id="reorder" class="form-control form-control-sm" placeholder="Reorder Quantity" required >
                <small class="text-danger" id="reorder_error_msg"></small>
              </div>
            <div class="col-lg my-2">
            <input type="checkbox" name="supplier" class="my-2" id="chk_supp"><small>&nbsp;&nbsp;Enable Supplier</small>
              <select class="form-control form-control-sm" id="supp-list" name="supp_id" disabled>
                <option value="">--Select Supplier--</option>
                <!-- ajax rendering -->
              </select> 
            </div>
          </div> 
          <div class="row my-2"> 
              <div class="col-lg mb-2">
                  <label for="avatar">Select Image</label>
                  <input type="file" name="product_image" class="form-control" id="fileimgupload">
              </div>
              <div class="col-lg">
                  <div id="dvimgPreview" class="avatar avatar-xxl">
                  </div>
              </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm" id="add_product_btn">Add Product</button>	
        </div>
			</form>
		</div>
	</div>
</div>


            <!-- //cash register modal -->
            <div class="modal fade" id="cashregisterclose" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Cash Register</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Cash Close</div>
                                        </div>
                                        <form id="pos_cash_close">
                                            @csrf
                                            <div class="">
                                                <div class="col">
                                                    <label for="cash_in_hand">User</label>
                                                    <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly
                                                        value="{{Auth::user()->name}}" required name="user" id="user">
                                                    <label for="cash_in_hand">Cash In hand</label>
                                                    <input type="number" class="form-control form-control-sm mb-2" tabindex=1
                                                        readonly value="" required name="cash_in_hand" id="cash_in_hand">
                                                    <label for="cash_in_hand">Total Sales</label>
                                                    <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly
                                                        value="" required name="total_sales" id="total_sales">
                                                    <label for="cash_in_hand">Cheques' Total</label>
                                                    <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly
                                                        value="0" required name="total_cheques" id="total_cheques">
                                                    <label for="cash_in_hand">Total Return</label>
                                                    <input type="number" class="form-control form-control-sm mb-2" tabindex=1
                                                        readonly value=0 required name="total_return" id="total_return">
                                                    <label for="cash_in_hand">Closing Amount</label>
                                                    <input type="number" class="form-control form-control-sm mb-2" tabindex=1
                                                        readonly required name="closing_amount" id="closing_amount">
                                                </div>
                                            </div>
                                            <div class="card-action ">
                                                <button type="submit" class="btn btn-sm btn-danger float-right mt--3"
                                                    id="btn_close">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--                 <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div> -->

                    </div>
                </div>
            </div>

            <!--Invoice Modal -->
            <div class="modal fade" id="searchinvoicesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Search Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-icon mx-3 mb-2">
                                <!--                     <input type="hidden" name="prod_id" id="invoice_id"> -->
                                <input type="text" class="form-control form-control-sm" required placeholder="Search Invoice..."
                                    name="search_invoice" id="search_invoice" autocomplete="off">
                                <span class="input-icon-addon">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="btn_search" class="btn btn-sm btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hold Invoices -->
            <div class="modal fade bd-example-modal-lg" id="hold_invoices_modal" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hold Invoices</h5>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="table-responsive" id="show_hold_invoices">
                                    <h1 class="text-center text-secondary my-5">Loading...</h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- hold invoice modal -->
            <div class="modal fade bd-example-modal-lg" id="holdinvoicelist" tabindex="-1" role="dialog" data-backdrop="static"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sale Invoice</h5>
                            <a class="btn btn-light text-capitalize border-0" id="printbtn" data-mdb-ripple-color="dark"><i
                                    class="fas fa-print text-primary"></i> Print
                            </a>
                        </div>
                        <div class="modal-body">
                            <div class="container" id="printholdinvoice">
                                <!-- rendring -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
    fetchallcustcat()
    loadcart();
    generateinvoice();
    
    //product

   fillcatadd();
   filluomadd();
   loadsuppliers();
   barcodecondition();
   $("#addCategoryModal").on('shown.bs.modal', function() {
        $("#addproductModal").css({ opacity: 0.3 });
        $("#editproductModal").css({ opacity: 0.3 });
        $('#addproductModal').css('z-index', 1039);

        $('#catmodal-footer').addClass('bg-grey2');
        $('#catmodal-header').addClass('bg-grey2');
        $('#cat_modal').removeClass('modal-lg');
        $('#cat_modal').addClass('modal-dialog-centered');
        $('input[name=cat_name]').focus();
    });
    $('#addCategoryModal').on('hidden.bs.modal', function () {
      $("#addproductModal").css({ opacity: 1 });
      $("#editproductModal").css({ opacity: 1 });
      $('#addproductModal').css('z-index', 1041);

        $('#catmodal-footer').removeClass('bg-grey2');
        $('#catmodal-header').removeClass('bg-grey2');
        $('#cat_modal').addClass('modal-lg');
        $('#cat_modal').removeClass('modal-dialog-centered');
    });
    //type
    $("#adduomModal").on('shown.bs.modal', function() {
        $("#addproductModal").css({ opacity: 0.3 });
        $("#editproductModal").css({ opacity: 0.3 });
        $('#addproductModal').css('z-index', 1039);

        $('#uommodal-footer').addClass('bg-grey2');
        $('#uommodal-header').addClass('bg-grey2');
        $('#uom-modal').removeClass('modal-lg');
        $('#uom-modal').addClass('modal-dialog-centered');
        $('input[name=uom_name]').focus();
    });
    $('#adduomModal').on('hidden.bs.modal', function () {
      $("#addproductModal").css({ opacity: 1 });
      $("#editproductModal").css({ opacity: 1 });
      $('#addproductModal').css('z-index', 1041);
        $('#uommodal-footer').removeClass('bg-grey2');
        $('#uommodal-header').removeClass('bg-grey2');
        $('#uom-modal').addClass('modal-lg');
        $('#uom-modal').removeClass('modal-dialog-centered');
    });


    function loadsuppliers(){
		$.ajax({
			url:'{{route('loadsuppliers')}}',
			method:'get',
			success:function(res)
			{
				var s='<option value="">--Select Supplier--</option>';
        for(var i = 0; i < res.length; i++) {
          s += '<option value="' + res[i].id + '" data-customvalue="'+ res[i].id +'">'+ res[i].supp_name + '</option>';     
        }
        $("#supp-list").html(s);    
        $("#edit_supp-list").html(s);    
			}
		})
	}
     //category dropdown fill
     function fillcatadd(){
      $.ajax({
				url:'{{route('fetchcombocat')}}',
				method:'get',
				success:function(res){
          output='<option value="">--Please select Category--</option>';
          for(i=0;i<res.length;i++){
            output +='<option value="'+res[i].id+'">'+res[i].cat_name+'</option>';
          }
				 	$('#addCategory').html(output);
				 	$('#editCategory').html(output);
				}
			})
    }

    
     function filluomadd(){
      $.ajax({
				url:'{{route('fetchcombouom')}}',
				method:'get',
				success:function(res){
          output='<option value="">--Please select UOM--</option>';
          for(i=0;i<res.length;i++){
            output +='<option value="'+res[i].id+'">'+res[i].uom_name+'</option>';
          }
				 	$('#adduom').html(output);
				 	$('#edituom').html(output);
				}
			})
    }
    //add UOM
		$('#add_uom_form').submit(function(e){
      
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_uom_btn').text('Adding...');
		$("#add_uom_btn").prop('disabled', true);
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
			method:'POST',
			url:'{{route('adduom')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
					$(".progress-bar").width('0%');
					if(res.status===200){
						$('#successsound').trigger('play')
						swal(
						'Added!',
						'UOM has been added successfully',
						'success'
						)
          filluomadd()
					$('#add_uom_btn').text('Add Category');
					$("#add_uom_btn").prop('disabled', false);
					$('#add_uom_form')[0].reset();
					$('#adduomModal').modal('hide');
					}
					
					}
		})
		})

    //add categories
		$('#add_category_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_category_btn').text('Adding...');
		$("#add_category_btn").prop('disabled', true);
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
			method:'POST',
			url:'{{route('addcategory')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
                $(".progress-bar").width('0%');
                if(res.status===200){
                    $('#successsound').trigger('play')
                    swal(
                    'Added!',
                    'Category has been added successfully',
                    'success'
                    )
                fillcatadd();
                $('#add_category_btn').text('Add Category');
                $("#add_category_btn").prop('disabled', false);
                $('#add_category_form')[0].reset();
                $('#addCategoryModal').modal('hide');
                }
                
            }

		})
		})
    function barcodecondition()
    {
      if($('#chkbarcode').is(':checked')){
      autogenbarcode();
      $("#upc_ean").prop('readonly', true);
      }else{
        $("#upc_ean").prop('readonly', false);
        $("#upc_ean").val("");
      }
    }

     //check autobarcode
     $('#chkbarcode').click(function(){
      barcodecondition();
    })
    //check autobarcode on modal open
    $('#addcustomer').click(function(){
      barcodecondition();
    })

    function autogenbarcode()
    {
      $.ajax({
        url:'{{route('auto_gen_barcode')}}',
        method:'get',
        success:function(res)
        {
          $('#upc_ean').val(res);
          $('.edit_upc_ean').val(res);
        }
      })
    }

    var today = new Date();
	//expiry check
	$('#apply_expiry').click(function(){
    //If the checkbox is checked.
    if($(this).is(':checked')){
        //Enable the Expiry date field
        $('#expiry_date').attr("readonly", false);
		document.getElementById("expiry_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("expiry_date").min = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    } else{
        //If it is not checked
        $('#expiry_date').attr("readonly", true);
		document.getElementById("expiry_date").value ="";
    }
    });
    $('#chk_supp').click(function(){
    //If the checkbox is checked.
    if($(this).is(':checked')){
      //Enable the Expiry date field
      $('#supp-list').attr("disabled", false);
      } 
    else{
    //If it is not checked
    $('#supp-list').attr("disabled", true);
    document.getElementById("supp-list").value ="";
    }
    });
 //calculate discount
 $("#discount").on('keyup',function(){
        var retail=$("#retail_price").val();
        var discount=$("#discount").val();
        (retail==="" ||retail===0) ? retail=0:retail=parseInt(retail);
        (discount===""||discount===0) ? discount=0:discount=parseInt(discount);
        discount=((discount/100)*retail);
        var finalprice=retail-discount;
        $("#final_price").val(finalprice);      
      })

      $("#retail_price").on('keyup',function(){
        var retail=$("#retail_price").val();
        var discount=$("#discount").val();
        (retail==="" ||retail===0) ? retail=0:retail=parseInt(retail);
        (discount===""||discount===0) ? discount=0:discount=parseInt(discount);
        discount=((discount/100)*retail);
        var finalprice=retail-discount;
        $("#final_price").val(finalprice);
      })

      $('#add_product_form').submit(function(e) {
  e.preventDefault();
  let checkqty=true;
  let checkcost=true;
  let checkretail=true;
  let checkreorder=true;
  let qty=parseInt($('#opening_qty').val())
  let cost=parseInt($('#cost_price').val())
  let retail=parseInt($('#retail_price').val())
  let reorder=parseInt($('#reorder').val())
  if(qty<=0)
  {
    $('#qty_error_msg').html('Quantity cannot be less than 1')
    checkqty=false;
  }
  else{
    $('#qty_error_msg').html('')
    checkqty=true;
  }
  if(cost<=0)
  {
    $('#cost_error_msg').html('Cost Price cannot be less than 0 or negative')
    checkcost=false;
  }
  else{
    $('#cost_error_msg').html('')
    checkcost=true;
  }
  if(retail<=0)
  {
    $('#retail_error_msg').html('Retail Price cannot be less than 0 or negative')
    checkretail=false;
  }else if(retail<cost)
  {
    $('#retail_error_msg').html('Cost Price cannot be less than retail price')
    checkretail=false;
  }else{
    $('#retail_error_msg').html('')
    check=true;
  }
  if(reorder<0)
  {
    $('#reorder_error_msg').html('Reorder quantity cannot be negative');
    checkreorder=false;
  }else{
    $('#reorder_error_msg').html('')
    checkreorder=true;
  }
  if(checkqty && checkcost && checkretail && checkreorder)
  {
    const cd = new FormData(this);
    $('#add_product_btn').text('Adding...');
    $("#add_product_btn").prop('disabled', true);
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
        method: 'POST',
        url: '{{route('addproducts')}}',
        data: cd,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".progress-bar").width('0%');
        },
        success: function(res) {
            $(".progress-bar").width('0%');
                $('#successsound').trigger('play')
                swal(
                    'Added!',
                    'Product has been added successfully',
                    'success'
                )
                $('#add_product_btn').text('Add Product');
                $("#add_product_btn").prop('disabled', false);
                $('#add_product_form')[0].reset();
                $("#dvPreview").html("");
                $('#addproductModal').modal('hide');

        }

    })
  }
})


$(function () {
    $("#fileimgupload").change(function () {
        $("#dvimgPreview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
           
                if (typeof (FileReader) != "undefined") {
                    $("#dvimgPreview").show();
                    $("#dvimgPreview").html("<img />");
                    $("#dvimgPreview img").addClass('avatar-img rounded');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#dvimgPreview img").attr("src", e.target.result);
                    }
                    reader.readAsDataURL($(this)[0].files[0]);
                } else {
                    alert("This browser does not support FileReader.");
                }
            
        } else {
            alert("Please upload a valid image file.");
        }
    });
});
function secondName()
{
  $('#gen_name').val('_'+$('#prod_name').val())
}
function editsecondName()
{
  $('#generic_name').val('_'+$('#product_name').val())
}
//manage stock
$('#stock_manage').click(function(){
    //If the checkbox is checked.
    managestock();
    });

    //managestock function
    function managestock()
    {
      if($('#stock_manage').is(':checked')){
      //Enable the Expiry date field
      $('#opening_qty').attr("disabled", true);
      $('#reorder').attr("disabled", true);
      $('#opening_qty').val(0);
      $('#reorder').val(0);
      } 
    else{
      //If it is not checked
      $('#opening_qty').attr("disabled", false);
      $('#reorder').attr("disabled", false);
    }
    }
    </script>
    
</html>