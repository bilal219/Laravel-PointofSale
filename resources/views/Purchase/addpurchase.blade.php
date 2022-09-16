@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Purchase</h4>
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
					<a href="#">Purchase</a>
				</li>	
			</ul>
		</div>
   		<div class="row mt--2">
			<div class="col-md-4">
				<div class="card full-height">
				<div class="card-header">
				<div class="card-title">Add To Cart &nbsp;&nbsp;&nbsp; <small class="text-danger"> Field names with * are mendatory</small></div>
						<div class="card-category">Select items to purchase</div>
					</div>
					<div class="card-body">
						<form id="purchase_form">
							@csrf
							<div class="col mb-3">
								<label for="search_name">Product &nbsp;<strong class="text-danger">*</strong></label>
								<div class="input-icon" style="width:100%">
									<input type="text" class="form-control form-control-sm" required placeholder="Search Product..." name="search_name" id="productlist" autocomplete="off">
									<span class="input-icon-addon">
										<i class="fa fa-search"></i>
									</span>
								</div>
							</div>
							<div class="col mb-3">
								<label for="search_name">Item name</label>
								<input type="hidden" name="prod_id" id="prod_id">
								<input type="text" class="form-control form-control-sm" tabindex="1" readonly id="prod_name">
							</div>
							<div class="col mb-3">
								<label for="search_name">Barcode</label>
								<input type="text" class="form-control form-control-sm" tabindex="2"readonly id="barcode">
							</div>
							<div class="col mb-3">
								<label for="search_name">Qty &nbsp;<strong class="text-danger">*</strong></label>
								<input type="number" class="form-control form-control-sm" required tabindex="3" name="purchase_qty" id="purchase_qty">
							</div>
							<div class="col mb-3">
								<label for="search_name">Purchase Price &nbsp;<strong class="text-danger">*</strong></label>
								<input type="number" class="form-control form-control-sm" required tabindex="4" name="cost_price" id="cost_price">
							</div>
							<div class="col mb-2">
								<label for="search_name">Retail Price &nbsp;<strong class="text-danger">*</strong></label>
								<input type="number" class="form-control form-control-sm" required tabindex="5" name="retail_price" id="retail_price">
							</div>
							<div class="form-check mb-1">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" tabindex="6" id="apply_expiry">
									<span class="form-check-sign">Apply Expiry</span>
								</label>
								<input type="date" class="form-control form-control-sm" readonly tabindex="7" name="expiry_date" id="expiry_date">
							</div>
							<div class="col">
								<button class="btn btn-xs btn-success pull-right"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card full-height">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h4 class="card-title">Add / Purchase Stock</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="row">
							<div class="col-md-3">
								<label for="dtp-form">Supplier &nbsp;<strong class="text-danger">*</strong></label>
								<select name="supplier_id" class="form-control form-control-sm mb-2" id="supp-list">
								  <option value="">--Select Supplier--</option>	
							    	<!-- ajax rendring -->
								</select>                                        
							</div>	
							<div class="col-md-3">
							<label for="dtp-form">Refrence # </label>
								<input type="text" name="refrence_no" readonly class="form-control form-control-sm mb-2" id="refrence_no">
							</div>			
							<div class="col-md-3 mb-2">
							<label for="dtp-form">Date </label>
								<input type="date" name="purchase_date" class="form-control form-control-sm mb-2" id="dtp_purchase">
							</div>			
							<div class="col-md-3 mb-2">
							<label for="dtp-form">Invoice # </label>
								<input type="text" name="invoice_no" readonly class="form-control form-control-sm mb-2" placeholder="PU-1" id="invoice_no">
							</div>			
						</div>
						<hr>
						<div class="d-flex align-items-center mb-3">
                            <h4 class="card-title">Purchase Detail</h4>
                            <div class="ml-auto">
                                <button id='btn-empty' class="btn btn-sm btn-primary  btn-border btn-round">
									<i class="fa fa-undo" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
						<div class="table-responsive">
							<table class="display table-sm table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Item Name</th>
										<th>Barcode</th>
										<th>Qty &nbsp;<small class="text-danger">(In Stock)</small></th>
										<th>New Qty</th>
										<th>Purchase Price</th>
										<th>Retail Price</th>
										<th>Total Price</th>
										<th>Expiry Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="purchase_cart_tbl">  
								</tbody>    
							</table>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex align-items-center">
							<div class="d-flex">
								<small>Total</small>&nbsp;&nbsp;&nbsp;	
								<input type="number" class="form-control form-control-sm text-primary" readonly name="purchase_total" id="purchase_total" placeholder="0">
							</div>
							<div class="ml-auto">
								<button class="btn btn-xs btn-primary" id="purchase_checkout"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Checkout</button>
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
	//generate invoice
	generateinvoice();
	var today = new Date();
	//expry check
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
	//autocomplete product
	$(document).ready(function(){
		//empty cart
		$("#btn-empty").click(function(){
			swal({
		icon : "info",
		title: 'Are you sure?',
		text: "You won't be able to revert this record!",
		type: 'warning',
		buttons:{
			cancel: {
				visible: true,
				className: 'btn btn-danger'
			},confirm: {
				text : 'Yes, remove all !',
				className : 'btn btn-success'
			}
		}
        }).then((Delete) => {
          if (Delete) {
			emptycart();
          }
        })
		}); 
		//load purchase cart
	     loadpurchasecart();
		 //autocomplete
		$('#productlist').autocomplete({
			source: function( request, response ) {
			// Fetch data
			$.ajax({
				url:"{{route('autocomplete')}}",
				type: 'post',
				dataType: "json",
				data: {
					_token:'{{csrf_token()}}',
					term: request.term
				},
				success: function( data ) {
				response( data );
				//console.log(data)
				}
			});
			},
			select: function (event, ui) {
				if(ui.item.expiry_date)
				{
					$('#apply_expiry').prop('checked',true);
					$('#expiry_date').attr("readonly", false);
					$('#expiry_date').val(ui.item.expiry_date);
				}else{
					$('#apply_expiry').prop('checked',false);
					$('#expiry_date').attr("readonly", true);
					$('#expiry_date').val("");
				}
				$('#productlist').val(ui.item.value);
				$('#barcode').val(ui.item.value);
				$('#prod_name').val(ui.item.prod_name);
				$('#retail_price').val(ui.item.prod_price);
				$('#cost_price').val(ui.item.cost_price);
				$('#prod_id').val(ui.item.prod_id);
				$('#purchase_qty').focus();
				return false;
			}
		})
    });
	function emptycart()
	{
		$.ajax({
		url:'{{route('emptypurchasecart')}}',
		method:'get',
		success:function(){
			loadpurchasecart();
		}
		})
	}
	/////////////////////////
	$(document).ready(function(){
    //load suppliers
	loadsuppliers();
	//load date
    document.getElementById("dtp_purchase").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    document.getElementById("dtp_purchase").min = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
	})
	function loadexpiry(){
		var today = new Date();
		document.getElementById("dtp_purchase").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
		document.getElementById("dtp_purchase").min = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
	}
	//load supplier
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
                $("#supp-list").html(s);
			}
		})
	}

	//add to purchase cart
	$('#purchase_form').submit(function(e){
    e.preventDefault();
    const fd=new FormData(this);
    $.ajax({
         method:'post',
         url:'{{route('addtopurchasecart')}}',
         data:fd,
         cache:false,
         processData:false,
         contentType:false,
         success:function(res)
        {   
            if(res.status===200)
            {
                $('#purchase_form')[0].reset();
				$('#productlist').focus();
				loadpurchasecart();       
            }
            $('#prod_id').val("");
            $(".ui-autocomplete").hide();
        }
    })
})

function generateinvoice()
{
	$.ajax({
        url:'{{route('purchaseinvoice')}}',
        method:'get',
        success:function(res){
           $('#invoice_no').val("PU-"+res.purchase_invoice_no)
        }
    })
}
$(document).on('click','.delfromcarticon',function(e){
    e.preventDefault();
    let prod_id=$(this).attr('id');
    $.ajax({
        method:'get',
        url:'{{route('removefrompurchasecart')}}',
        data:
        {
            id:prod_id,
            _token:'{{csrf_token()}}'
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadpurchasecart();
            }
            $('#prod_id').val("");

        }

    })

})
//load purchase cart
function loadpurchasecart()
{
	$.ajax({
		url:'{{route('loadpurchasecart')}}',
		method:'get',
		success:function(res){
		$('#purchase_cart_tbl').html(res.cart);
		$("#purchase_total").val(res.order_total)	
		}
	})
}
// warning before leaving the page
// $(window).on('beforeunload',function(){
// 	var c=confirm();
// 	if(c){
//         $.ajax({
// 			url:'{{route('emptypurchasecart')}}',
// 			method:'get',
// 			success:function(){
// 				return true;
// 			}
// 		})
// 	}
// 	else{
// 		return false;
// 	}
// })

// purchase checkout
$(document).on('click','#purchase_checkout',function(e){
    $("#purchase_checkout").prop('disabled', true);
	var supp_id=$("#supp-list").val();
	var refrence_no=$("#refrence_no").val();
	var date=$("#dtp_purchase").val();
	var invoice_no=$("#invoice_no").val();    
    $.ajax({
        url:'{{route('completepurchase')}}',
        method:'post',
        data:{
            supp_id:supp_id,
			refrence_no:refrence_no,
			date:date,
            invoice_no:invoice_no,
            _token:'{{csrf_token()}}',
        },
        success:function(res)
        {
            if(res===200)
            {     
				emptycart();
				$("#supp-list").val("");
				generateinvoice();
				swal("Success!", "Stock has been added successfully!", {
                    icon : "success",
                    buttons: {
                        confirm: {
                            className : 'btn btn-success'
                        }
                    },
                });
			}
			else if(res===202){
				swal("Warning!", "Please Select Supplier!", {
                    icon : "warning",
                    buttons: {
                        confirm: {
                            className : 'btn btn-warning'
                        }
                    },
                });
			}
			else if(res===404)
			{
				swal("Warning!", "Cart is empty,please add some products!", {
                    icon : "warning",
                    buttons: {
                        confirm: {
                            className : 'btn btn-warning'
                        }
                    },
                });
			}
            $("#purchase_checkout").prop('disabled', false);
        }
    })
})
</script>
@endsection
