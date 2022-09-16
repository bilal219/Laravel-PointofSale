@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Purchase Return</h4>
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
                    <a href="#">Purchase Return</a>
                </li>  
            </ul>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Purchase Return</h4>
                        <div class="ml-auto">
                            <input type="text" id="purchase_return_invoice_no" readonly class="form-control form-control-sm ml-auto">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-primary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="false">Return without Invoice</a>
                        </li>
                        <li class="nav-item submenu">
                            <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false">Return with invoice</a>
                        </li>
                        <!-- <li class="nav-item submenu">
                            <a class="nav-link" id="pills-contact-tab-nobd" data-toggle="pill" href="#pills-contact-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="true">Return List</a>
                        </li> -->
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                        <div class="tab-pane fade active show" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                            <form id="form_purchase_product_return">
                                @csrf
                                <div class="col row my-4">
                                    <div class="input-icon mx-3 mb-2" style="width:40%">
                                        <input type="hidden" name="preturn_prod_id" id="preturn_prod_id">
                                        <input type="text" class="form-control form-control-sm" required placeholder="Search Product..." name="purchase_return_prod_name" id="purchasereturnprod" autocomplete="off">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div> 
                                    <div class="ml-3">
                                        <input type="number"  class="form-control form-control-sm" min=1 value="1" name="purch_return_qty" id="purch_return_qty">
                                    </div>
                                    <div>
                                        <button type="submit" value="Add" class="btn btn-link btn-sm mx-2 text-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="ml-auto">
                                        <button id='btn_purchase_return_empty' class="btn btn-sm btn-primary btn-border btn-round">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="row">
							<div class="col-md-3">
								<label for="dtp-form">Supplier &nbsp;<strong class="text-danger">*</strong></label>
								<select name="supplier_id" class="form-control form-control-sm mb-2" id="purch_returnsupp_list">
								  <option value="">--Select Supplier--</option>	
							    	<!-- ajax rendring -->
								</select>                                        
							</div>	
							<div class="col-md-3">
							    <label for="dtp-form">Refrence # </label>
								<input type="text" name="refrence_no" readonly class="form-control form-control-sm mb-2" id="purch_return_refrence_no">
							</div>			
							<div class="col-md-3 mb-2">
							    <label for="dtp-form">Date </label>
								<input type="date" name="purchase_date" class="form-control form-control-sm mb-2" id="dtp_purchase_return">
							</div>						
						</div>
						<hr>
                            <div class="table-responsive">
                                <table class="display table-sm table-bordered" style="width:100%" id="purchaseproductreturn">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Barcode</th>
                                            <th>In Stock</th>
                                            <th>Return QTY</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="return_cart_tbl">  
                                    </tbody>    
                                </table>
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <strong class="mt-1">Total </strong>&nbsp;&nbsp;&nbsp;	
                                        <input type="number" class="form-control form-control-sm text-primary" readonly name="purchase_return_total" id="purch_return_total" placeholder="0">
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-xs btn-primary" id="purchase_return_checkout"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Complete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                            <form id="form_purchase_invoice_return">
                                @csrf
                                <div class="col row my-4">
                                    <div class="input-icon mx-3 mb-2">
                                        <input type="text" class="form-control form-control-sm" required placeholder="Search Invoice..." name="search_invoice" id="purchasereturninvoice" autocomplete="off">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div> 
                                    <input type="hidden" id="purchasereturninvoice_no">
                                    <div>
                                        <button type="submit" value="Add" class="btn btn-link btn-sm mx-2 text-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="ml-auto">
                                        <button id='btn_preturn_invoice_empty' class="btn btn-sm btn-primary btn-border btn-round">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="table-responsive">
                                <table class="display table-sm table-bordered" style="width:100%" id="purchaseinvoicereturn">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Purchase QTY</th>
                                            <th>Return QTY</th>
                                            <th>Transaction QTY</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pur_invoice_cart_tbl">  
                                    </tbody>    
                                </table>
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <strong class="mt-1">Total </strong>&nbsp;&nbsp;&nbsp;	
                                        <input type="number" class="form-control form-control-sm text-primary" readonly name="invoice_total" id="pur_invoice_total" placeholder="0">
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-xs btn-primary" id="pur_invoice_checkout"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Complete</button>
                                    </div>
                                </div>
                            </div>                       
                        </div>
                        <div class="tab-pane fade" id="pills-contact-nobd" role="tabpanel" aria-labelledby="pills-contact-tab-nobd">
                            return list
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
    generatepurchreturninvoice();
    $(document).ready(function(){
        //load suppliers
        loadsuppliers();
        //load date
        var today = new Date();
        document.getElementById("dtp_purchase_return").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("dtp_purchase_return").min = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    })
    loadpurchasereturncart();
    //autocomplete
    $(document).ready(function(){
        $('#purchasereturnprod').autocomplete({
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
               $('#returnproductlist').val(ui.item.value);
               $('#preturn_prod_id').val(ui.item.prod_id);
               $('#purch_return_qty').focus().select();
               return false;
            }
       })
    })

    //add to purchase return cart
	$('#form_purchase_product_return').submit(function(e){
        e.preventDefault();
        const fd=new FormData(this);
        $.ajax({
            method:'post',
            url:'{{route('addtopurchreturncart')}}',
            data:fd,
            cache:false,
            processData:false,
            contentType:false,
            success:function(res)
            {   
                if(res.status===200)
                {
                    $('#form_purchase_product_return')[0].reset();
                    loadpurchasereturncart();       
                }
                $(".ui-autocomplete").hide();
            }
        })
    })

    //load purchase return return cart
    function loadpurchasereturncart()
    {
        $.ajax({
            url:'{{route('loadpurchasereturncart')}}',
            method:'get',
            success:function(res){
            $('#return_cart_tbl').html(res.cart);
            $("#purch_return_total").val(res.order_total)	
            }
        })
    }

    //remove purchase return items
    $(document).on('click','.delpurchreturnitem',function(e){
        e.preventDefault();
        let prod_id=$(this).attr('id');
        $.ajax({
            method:'get',
            url:'{{route('removepurchitem')}}',
            data:
            {
                id:prod_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                if(res.status===200)
                {
                    loadpurchasereturncart();
                }
                $('#preturn_prod_id').val("");

            }

        })

    })

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
                $("#purch_returnsupp_list").html(s);
			}
		})
	}

    //inline changing in the Purchase Retuen table
    $(document).on('dblclick','#purchaseproductreturn tbody tr',function()
    {
        var id=$(this).attr('id');
        var return_qty=$(this).find('td:eq(3)');
        var $input = $('<input>', {
            value: return_qty.text(),
            min:1,
            type: 'number',
            blur: function() {
                var qty=this.value;
                $.ajax({
                    url:'{{route('inlinePurchasechange')}}',
                    method:'post',
                    data:{
                        id:id,
                        qty:qty,
                        _token:'{{csrf_token()}}',
                    },
                    success:function(res)
                    {
                        loadpurchasereturncart();     
                    }
                })
                // return_qty.text(this.value);
            },
            keyup: function(e) {
            if (e.which === 13) $input.blur();
            }
        }).appendTo( return_qty.empty() ).focus().select();
    })

    //invoice
    function generatepurchreturninvoice()
    {
        $.ajax({
            url:'{{route('purchasereturninvoice')}}',
            method:'get',
            success:function(res){
            $('#purchase_return_invoice_no').val("PR-"+res.purch_return_invoice)
            }
        })
    }

    //empty cart
    $(document).ready(function(){
            //empty cart
            $("#btn_purchase_return_empty").click(function(){
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
                emptypurchasereturncart();
            }
            })
        }); 
    });
    //empty return cart
    function emptypurchasereturncart()
    {
        $.ajax({
        url:'{{route('emptypurchasereturncart')}}',
        method:'get',
        success:function(){
            loadpurchasereturncart();
        }
        })
    }
     //purchase return checkout
    $(document).on('click','#purchase_return_checkout',function(e){
    $("#purchase_return_checkout").prop('disabled', true);
	var supp_id=$("#purch_returnsupp_list").val();
	var refrence_no=$("#purch_return_refrence_no").val();
	var date=$("#dtp_purchase_return").val();
	var invoice_no=$("#purchase_return_invoice_no").val();    
    $.ajax({
        url:'{{route('completepurchasereturn')}}',
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
				emptypurchasereturncart();
				$("#purch_returnsupp_list").val("");
				generatepurchreturninvoice();
				swal("Success!", "Stock has been return successfully successfully!", {
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
            $("#purchase_return_checkout").prop('disabled', false);
        }
    })
})

//purchase return invoice autocomplete
$('#purchasereturninvoice').autocomplete({
        source: function( request, response ) {
        // Fetch data
        $.ajax({
            url:"{{route('prinvautocomplete')}}",
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
            $('#purchasereturninvoice').val(ui.item.value);
            $('#purchasereturninvoice_no').val(ui.item.value);
            return false;
        }
    })

    //add to return invoice cart
	$('#form_purchase_invoice_return').submit(function(e){
        e.preventDefault();
        const fd=new FormData(this);
        $.ajax({
            method:'post',
            url:'{{route('addtopinvoicecart')}}',
            data:fd,
            cache:false,
            processData:false,
            contentType:false,
            success:function(res)
            {   
                $('#purchasereturninvoice_no').val($('#purchasereturninvoice').val());
                $('#purchasereturninvoice').val("");
                if(res.status===200)
                {
                    loadpurinvoicecart();    

                }
                $(".ui-autocomplete").hide();
            }
        })
    })

    //load return cart
    function loadpurinvoicecart()
    {
        $.ajax({
            url:'{{route('loadpinvoicereturncart')}}',
            method:'get',
            success:function(res){
            $('#pur_invoice_cart_tbl').html(res.cart);
            $("#pur_invoice_total").val(res.order_total)	
            }
        })
    }


    //remove purchase invoice return items
    $(document).on('click','.delpurinvoiceitem',function(e){
        e.preventDefault();
        let prod_id=$(this).attr('id');
        $.ajax({
            method:'get',
            url:'{{route('removepurinvoicereturn')}}',
            data:
            {
                id:prod_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                if(res.status===200)
                {
                    loadpurinvoicecart();
                }

            }

        })

    })

    //inline changing in the Purchase invoice table
    $(document).on('dblclick','#purchaseinvoicereturn tbody tr',function()
    {
        var id=$(this).attr('id');
        var return_qty=$(this).find('td:eq(2)');
        var sold_qty=$(this).find('td:eq(1)').text();
        var $input = $('<input>', {
            value: return_qty.text(),
            min:1,
            type: 'number',
            blur: function() {
                var qty=this.value;
                if(qty<=0 || qty==null)
                {
                    swal("Warning!", "Quantity cannot be empty 0 or negative. ", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                    this.value=return_qty.text();
                }
                else if(parseInt(sold_qty)<parseInt(qty))
                {
                    swal("Warning!", "Return quantity cannot be greater than Purchase quantity", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
                else{
                    $.ajax({
                        url:'{{route('inlinepurinvoicechange')}}',
                        method:'post',
                        data:{
                            id:id,
                            qty:qty,
                            _token:'{{csrf_token()}}',
                        },
                        success:function(res)
                        {
                            loadpurinvoicecart();     
                        }
                    })
                    // return_qty.text(this.value);
                }
            },
            keyup: function(e) {
            if (e.which === 13) $input.blur();
            }
        }).appendTo( return_qty.empty() ).focus().select();
    })
 
    //empty the invoice return cart
    function emptypurchaseinvreturncart()
    {
        $.ajax({
        url:'{{route('emptypurchaseinvreturncart')}}',
        method:'get',
        success:function(){
            loadpurinvoicecart();
        }
        })
    }

    //empty purchase invoice return cart
    $(document).ready(function(){
        //empty cart
        $("#btn_preturn_invoice_empty").click(function(){
            swal({
            icon : "info",
            title: 'Are you sure?',
            text: "You won't be able to revert this record!",
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
                    emptypurchaseinvreturncart();
                }
            })
        }); 
    });

    //purchase invoice return checkout
    $(document).on('click','#pur_invoice_checkout',function(e){
        e.preventDefault();
        // $("#return_checkout").prop('disabled', true);
        var return_invoice_no=$('#purchase_return_invoice_no').val();
        var invoice_no=$('#purchasereturninvoice_no').val();
        $.ajax({
            url:'{{route('purchaseinvoicereturn')}}',
            method:'post',
            data:{
                invoice_no:invoice_no,
                return_invoice_no:return_invoice_no,
                _token:'{{csrf_token()}}',
            },
            success:function(res)
            {
                if(res==200)
                {
                    emptypurchaseinvreturncart();
                    generatepurchreturninvoice();
                    swal("Success!", "Products have been returned successfully!", {
                        icon : "success",
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    });
                    $('#purchasereturninvoice_no').val("");
                }
                else if(res==202)
                {
                    swal("Warning!", "Please select some product to return!", {
                        icon : "warning",
                        buttons: {
                            confirm: {
                                className : 'btn btn-warning'
                            }
                        },
                    }); 
                }
            }
        })
    })

</script>
@endsection