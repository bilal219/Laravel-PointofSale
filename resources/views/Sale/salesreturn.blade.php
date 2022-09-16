@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Sales Return</h4>
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
                    <a href="#">Sales Return</a>
                </li>
                
            </ul>
        </div>
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Sales Return</h4>
                        <div class="ml-auto">
                            <input type="text" id="return_invoice_no" readonly class="form-control form-control-sm ml-auto">
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
                            <form id="form_return_only">
                                @csrf
                                <div class="col row my-4">
                                    <div class="input-icon mx-3 mb-2" style="width:40%">
                                        <input type="hidden" name="prod_id" id="prod_id">
                                        <input type="text" class="form-control form-control-sm" required placeholder="Search Product..." name="search_name" id="returnproductlist" autocomplete="off">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div> 
                                    <div class="ml-3">
                                        <input type="number"  class="form-control form-control-sm" min=1 value="1" name="return_qty" id="return_qty">
                                    </div>
                                    <div>
                                        <button type="submit" value="Add" class="btn btn-link btn-sm mx-2 text-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="ml-auto">
                                        <button id='btn-return-empty' class="btn btn-sm btn-primary btn-border btn-round">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="table-responsive">
                                <table class="display table-sm table-bordered" style="width:100%" id="productreturn">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
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
                                        <input type="number" class="form-control form-control-sm text-primary" readonly name="return_total" id="return_total" placeholder="0">
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-xs btn-primary" id="return_checkout"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Complete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
                            <form id="form_invoice_return">
                                @csrf
                                <div class="col row my-4">
                                    <div class="input-icon mx-3 mb-2">
                                        <input type="hidden" name="prod_id" id="prod_id">
                                        <input type="text" class="form-control form-control-sm" required placeholder="Search Invoice..." name="search_invoice" id="returninvoice" autocomplete="off">
                                        <span class="input-icon-addon">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div> 
                                    <input type="hidden" id="returninvoice_no">
                                    <div>
                                        <button type="submit" value="Add" class="btn btn-link btn-sm mx-2 text-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="ml-auto">
                                        <button id='btn-invoice-empty' class="btn btn-sm btn-primary btn-border btn-round">
                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="table-responsive">
                                <table class="display table-sm table-bordered" style="width:100%" id="invoicereturn">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Sold QTY</th>
                                            <th>Return QTY</th>
                                            <th>Transaction QTY</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_cart_tbl">  
                                    </tbody>    
                                </table>
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        <strong class="mt-1">Total </strong>&nbsp;&nbsp;&nbsp;	
                                        <input type="number" class="form-control form-control-sm text-primary" readonly name="invoice_total" id="invoice_total" placeholder="0">
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-xs btn-primary" id="invoice_checkout"><i class="fa fa-check" tabindex="8" aria-hidden="true"></i>&nbsp;&nbsp;Complete</button>
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
   // generate invoice
   generateinvoice();
    loadreturncart();
    $(document).ready(function()
    {
        loadsaleinvoicecart();
    })
    //autocomplete
    $('#returnproductlist').autocomplete({
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
            $('#returnproductlist').val(ui.item.value);
            $('#prod_id').val(ui.item.prod_id);
            $('#return_qty').focus();
            $('#return_qty').select();
            return false;
        }
    })

     //invoice autocomplete
     $('#returninvoice').autocomplete({
        source: function( request, response ) {
        // Fetch data
        $.ajax({
            url:"{{route('srinvautocomplete')}}",
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
            $('#returninvoice').val(ui.item.value);
            $('#returninvoice_no').val(ui.item.value);
            return false;
        }
    })

    //add to return invoice cart
	$('#form_invoice_return').submit(function(e){
        $('#returninvoice_no').val($('#returninvoice').val())
        e.preventDefault();
        const fd=new FormData(this);
        $.ajax({
            method:'post',
            url:'{{route('addtoinvoicecart')}}',
            data:fd,
            cache:false,
            processData:false,
            contentType:false,
            success:function(res)
            {   
                if(res.status===200)
                {
                    $('#returninvoice').val("")
                    loadsaleinvoicecart();       
                }
                $(".ui-autocomplete").hide();
            }
        })
    })

    //add to return cart
	$('#form_return_only').submit(function(e){
        e.preventDefault();
        const fd=new FormData(this);
        $.ajax({
            method:'post',
            url:'{{route('addtoreturncart')}}',
            data:fd,
            cache:false,
            processData:false,
            contentType:false,
            success:function(res)
            {   
                if(res.status===200)
                {
                    $('#form_return_only')[0].reset();
                    $('#returnproductlist').focus();
                    loadreturncart();       
                }
                $('#prod_id').val("");
                $(".ui-autocomplete").hide();
            }
        })
    })

    //load return cart
    function loadreturncart()
    {
        $.ajax({
            url:'{{route('loadreturncart')}}',
            method:'get',
            success:function(res){
            $('#return_cart_tbl').html(res.cart);
            $("#return_total").val(res.order_total)	
            }
        })
    }

    //load return cart
    function loadsaleinvoicecart()
    {
        $.ajax({
            url:'{{route('loadinvoicereturncart')}}',
            method:'get',
            success:function(res){
            $('#invoice_cart_tbl').html(res.cart);
            $("#invoice_total").val(res.order_total)	
            }
        })
    }

    //remove return items
    $(document).on('click','.delreturnitem',function(e){
        e.preventDefault();
        let prod_id=$(this).attr('id');
        $.ajax({
            method:'get',
            url:'{{route('removesalereturn')}}',
            data:
            {
                id:prod_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                if(res.status===200)
                {
                    loadreturncart();
                }
                $('#prod_id').val("");

            }

        })

    })
    //remove invoice return items
    $(document).on('click','.delinvoiceitem',function(e){
        e.preventDefault();
        let prod_id=$(this).attr('id');
        $.ajax({
            method:'get',
            url:'{{route('removesaleinvoicereturn')}}',
            data:
            {
                id:prod_id,
                _token:'{{csrf_token()}}'
            },
            success:function(res)
            {
                if(res.status===200)
                {
                    loadsaleinvoicecart();
                }

            }

        })

    })


    //inline changing in the table
    $(document).on('dblclick','#productreturn tbody tr',function()
    {
        var id=$(this).attr('id');
        var return_qty=$(this).find('td:eq(1)');
        var $input = $('<input>', {
            value: return_qty.text(),
            min:1,
            type: 'number',
            blur: function() {
                var qty=this.value;
                if(qty<=0 || qty==null)
                {
                    swal("Warning!", "Return quantity cannot empty 0 or negative. ", {
                        icon : "error",
                        buttons: {
                            confirm: 
                            {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                    $input.value=return_qty.text();
                }
                else{
                    $.ajax({
                        url:'{{route('inlinechange')}}',
                        method:'post',
                        data:{
                            id:id,
                            qty:qty,
                            _token:'{{csrf_token()}}',
                        },
                        success:function(res)
                        {
                        loadreturncart();     
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
    //inline changing in the invoice table
    $(document).on('dblclick','#invoicereturn tbody tr',function()
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
                    swal("Warning!", "Return quantity cannot be greater than sold quantity", {
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
                        url:'{{route('inlineinvoicechange')}}',
                        method:'post',
                        data:{
                            id:id,
                            qty:qty,
                            _token:'{{csrf_token()}}',
                        },
                        success:function(res)
                        {
                        loadsaleinvoicecart();     
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

    //empty cart
    $(document).ready(function(){
            //empty cart
            $("#btn-return-empty").click(function(){
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
    });
    //empty return cart
    function emptycart()
    {
        $.ajax({
        url:'{{route('emptyreturncart')}}',
        method:'get',
        success:function(){
            loadreturncart();
        }
        })
    }
    //invoice cart
    function emptyinvoicecart()
    {
        $.ajax({
        url:'{{route('emptyinvoicecart')}}',
        method:'get',
        success:function(){
            loadsaleinvoicecart();
        }
        })
    }
    //invoice
    function generateinvoice()
    {
        $.ajax({
            url:'{{route('salereturninvoice')}}',
            method:'get',
            success:function(res){
            $('#return_invoice_no').val("SR-"+res.sale_return_invoice)
            }
        })
    }

    //product return checkout
    $(document).on('click','#return_checkout',function(e){
        e.preventDefault();
        // $("#return_checkout").prop('disabled', true);
        var invoice_no=$('#return_invoice_no').val();
        $.ajax({
            url:'{{route('productreturn')}}',
            method:'post',
            data:{
                invoice_no:invoice_no,
                _token:'{{csrf_token()}}',
            },
            success:function(res)
            {
                if(res==200)
                {
                    emptycart();
                    $("#supp-list").val("");
                    generateinvoice();
                    swal("Success!", "Products have been returned successfully!", {
                        icon : "success",
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    });
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

    //product invoice return checkout
    $(document).on('click','#invoice_checkout',function(e){
        e.preventDefault();
        // $("#return_checkout").prop('disabled', true);
        var return_invoice_no=$('#return_invoice_no').val();
        var invoice_no=$('#returninvoice_no').val();
        $.ajax({
            url:'{{route('productinvoicereturn')}}',
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
                    emptyinvoicecart();
                    generateinvoice();
                    swal("Success!", "Products have been returned successfully!", {
                        icon : "success",
                        buttons: {
                            confirm: {
                                className : 'btn btn-success'
                            }
                        },
                    });
                    $('#returninvoice_no').val("");

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

    //empty invoice cart
    $(document).ready(function(){
        //empty cart
        $("#btn-invoice-empty").click(function(){
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
                emptyinvoicecart();
            }
        })
    }); 
});
</script>
@endsection