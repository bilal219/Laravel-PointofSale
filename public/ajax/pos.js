    //autocomplete product
    $(document).ready(function(){
     $('#productlist').autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:'autocomplete',
            type: 'post',
            dataType: "json",
            data: {
                _token:$('meta[name="csrf-token"]').attr('content'),
                term: request.term
            },
            success: function( data ) {
               response( data );
               //console.log(data)
            }
          });
        },
        select: function (event, ui) {
           $('#productlist').val(ui.item.value);
           $('#pro_name').val(ui.item.prod_name);
           $('#saleprice').val(ui.item.prod_price);
           $('#prod_id').val(ui.item.prod_id);
           $('#prd_qty').focus();
           $('#prd_qty').select();
           return false;
        }
     })
    });    
    //fetchcustomer & categories
function fetchallcustcat(){
    $.ajax({
        url:'fetchall',
        method:'get',
        success:function(res){
            $('#prod_cat').html(res.categories); 
            $('#cust_data').html(res.customers); 
            $('#prod_data').html(res.products);
            fetchcust_info()
            previousbalance($('#cust_data').val());
        }
    })
    return true;
}
//pos invoice generator
function generateinvoice()
{
    $.ajax({
        url:'invoice_generator',
        method:'get',
        success:function(res){
           $('#invoice_no').val("SL-"+res.invoice_no)
        }
    })
    return true;
}
//loadcart
function loadcart()
{
    $.ajax({
        url:'loadcart',
        method:'get',
        success:function(res){
        $('#cart_tbl').html(res.cart);
        if(res.order_total===0)
        {
            $('#order_total').html('00');
        }
        else
        {
            $('#order_total').html(res.order_total);
        }
          cal_netpayable();
        }
    })
    return true;
}
//category wise filter
function filterprods()
{
    var catid=$('#prod_cat').val();
$.ajax({
    method:'get',
    url:'fetchprods',
    data:{
    id:catid,
    _token:'{{csrf_token()}}'
    },
    success:function(res){
     $('#prod_data').html(res);
    }
})
}
//fwtch customer information
function fetchcust_info()
{
    var custid=$('#cust_data').children("option:selected").val();
    $.ajax({
    method:'get',
    url:'fetchcustinfo',
    data:{
    id:custid,
    _token:'{{csrf_token()}}'
    },
    success:function(res){
      $('#cust_name').val(res.cust_name);
      $('#cust_contact').val(res.contact);
    }
})
return true;

}

// getting product on search

$(document).ready(function () {
            
    var ProductName = this.value;
    $.ajax({
        url: 'searchproducts',
        type: "get",
        data: {
            product_name: ProductName,
            _token: '{{csrf_token()}}'
        },
        success: function (res) {
            var s='<option value="">--Select Product--</option>';
            
            for (var i = 0; i < res.length; i++) {
                    s += '<option value="' + res[i].id + '" data-customvalue="'+ res[i].id +'">'+ res[i].product_name + '</option>';
                    
                }
                $("#productlist").html(s);
        }
    });          
 });

//addto cart
$('#posform').submit(function(e){
    e.preventDefault();
    const fd=new FormData(this);
    $.ajax({
        method:'post',
        url:'addtocart',
        data:fd,
        cache:false,
        processData:false,
        contentType:false,
        success:function(res)
        {   
            if(res.status===200)
            {
                $('#posform')[0].reset();
                    loadcart();       
            }
            else if(res.status===201)
            {
                swal("Warning!", "The require quantity is not available!", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }
            else if(res.status===202)
            {
                swal("Warning!", "The require quantity is not available anymore!", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }
            $('#prod_id').val("");
            $(".ui-autocomplete").hide();
            $("#productlist").focus();

        }
    })
})
// remove from cart
$(document).on('click','.delfromcarticon',function(e){
    e.preventDefault();
    let prod_id=$(this).attr('id');
    $.ajax({
        method:'get',
        url:'removefromcart',
        data:
        {
            id:prod_id,
            _token:'{{csrf_token()}}'
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadcart();
            }
            $('#prod_id').val("");

        }

    })

})
//calculate discount
function cal_netpayable()
{
    var order_total=parseInt($("#order_total").text());
    var discount=$('#discount_textbox').val();
    var payables=0;
    var prev_balance=parseInt($('#sal_prev_bal').text());
    if ($("#percentradio").prop("checked"))
    { discount!=="" ? discount=(parseInt(discount)*(order_total+prev_balance))/100 : discount=0;}
      
    (discount!=="" || discount!==0)? payables=(order_total+prev_balance-discount):payables=(order_total+prev_balance-0);
    (discount==="" || discount===0) ?  $('#discount_amount').html('00') : $('#discount_amount').html(discount); 
    payables!==0 ? $('#net_payable').html(payables) : $('#net_payable').html('00');
    cal_change();
}
//calculate change
function cal_change()
{
    var change=0;
    var order_total=parseInt($("#net_payable").text());
    var payment=$('#pyment_amount').val();
    payment !=="" ?payment=parseInt(payment) :payment=0;
    change=payment-order_total;
    $('#change_amount').val(change);


}

$('#pyment_amount').on('focus',function(){
    $('#pyment_amount').select();
})
// fetch product infromation
// function fetchpro_info()
// {
//     var proid=$('#productlist').children("option:selected").val();
//     $.ajax({
//     method:'get',
//     url:'{{route('fetchproinfo')}}',
//     data:{
//     id:proid,
//     _token:'{{csrf_token()}}'
//     },
//     success:function(res){
//       $('#pro_name').val(res.product_name);
//       $('#saleprice').val(res.retailprice);
//     }
//   });
// } 

$(document).on('click','.addgridcart',function(e){
   e.preventDefault();
   let pro_id=$(this).attr('id');
   $.ajax({
        method:'post',
        url:'addcartgrid',
        data:{
        id:pro_id,
        _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadcart();
            }
            else if(res.status===201)
            {
                swal("Warning!", "The require quantity is not available!", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }
            else if(res.status===202)
            {
                swal("Warning!", "The require quantity is not available anymore!", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }
        }
   })
})

$(document).on('click','#btn_checkout',function(e){
    $("#btn_checkout").prop('disabled', true);

    var cust_id=$('#cust_data').children("option:selected").val();
    var order_total=parseInt($("#order_total").text());
    var net_payable=parseInt($("#net_payable").text());
    var prev_balance=parseInt($("#sal_prev_bal").text());
    var discount_amount=parseInt($("#discount_amount").text());
    var payment_amount=parseInt($("#pyment_amount").val());
    var change_amount=parseInt($("#change_amount").val());
    var invoice_no=$('#invoice_no').val();
    $.ajax({
        url:'salecheckout',
        method:'post',
        data:{
            cust_id:cust_id,
            order_total:order_total,
            net_payable:net_payable,
            discount_amount:discount_amount,
            payment_amount:payment_amount,
            change_amount:change_amount,
            invoice_no:invoice_no,
            prev_balance:prev_balance,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            if(res.status==200)
            {        
                if(reset()){
                    if(generateinvoice())
                    {
                        invoiceprint(invoice_no)
                    }
                }
            }else if(res.status==201){
                swal("Information!", "'Payment Amount' cannot be less than 'Net Payables'", {
                    icon : "info",
                    buttons: {
                        confirm: {
                            className : 'btn btn-info'
                        }
                    },
                });
            }else if(res.status==202)
            {
                swal("Warning!", "For the transaction please add some product in cart. ", {
                    icon : "warning",
                    buttons: {
                        confirm: {
                            className : 'btn btn-warning'
                        }
                    },
                });
            }
            $("#btn_checkout").prop('disabled', false);

        }

    })
})
   
// empty cart   
function emptycart()
{
    $.ajax({
        method:'get',
        url:'emptycart',
        success:function()
        {
            loadcart();
        }
    })
}
// reset all
function reset()
{
    $('#cust_data').prop("selectedIndex", 0);
    //$('#select2-cust_data-container').text($('#cust_data').prop("selectedIndex", 0).text())
    fetchcust_info();
    $('#discount_amount').html("00")
    $('#sal_prev_bal').html("00")
    $('#change_amount').val(0);
    $('#discount_textbox').val("");
    $('#pyment_amount').val(0);
    $("#btn_checkout").prop('disabled', false);
    emptycart();
    return true;
}

function invoiceprint(invoice)
{
    var invoice_no=invoice
    $.ajax({
        method:'post',
        url:'invoiceprint',
        data:{
            invoice:invoice_no,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        cache:false,
        success:function(res)
        {
          $('#printinvoice').html(res);
          $('#invoice').modal('show');
          //console.log(res)

        }
    })
}
$('#printsalereciptbtn').on('click',function(){
   $('#printinvoice').printThis();
})
$(document).on('click','#refresh',function(){
    

    swal({
        icon: "info",
        title: 'Are you sure?',
        text: "You won't be able to revert this record!",
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes, Refresh it!',
                className: 'btn btn-success'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            $.ajax({
                method:'get',
                url:'emptycart',
                success:function(res)
                {
                    loadcart();
        
                }
            })
        }
    })
})
$('#cashclosepos').on('click',function(){
    $.ajax({
        method:'get',
        url:'poscashregister',
        success:function(res)
        {
            $('#cash_in_hand').val(res.cash_in_hand);
            $('#closing_amount').val(res.closing_amount);
            $('#total_sales').val(res.sales_total);
            $('#total_cheques').val(res.cheque_total);
            $('#total_return').val(res.return_amount);
        }
    })
})
$(document).on('submit','#pos_cash_close',function(e){
    e.preventDefault();
    $('#btn_close').attr('disable',true);
    const cd=new FormData(this);
    $.ajax({
        url:'closeregister',
        method:'post',
        data:cd,
        cache:false,
        processData:false,
        contentType:false,
        success:function(res)
        {
           if(res.status===200)
           {
            swal({
                title: 'Success!',
                text: "Cash register has benn closed successfully!",
                icon: "success",
                type: 'success',
                buttons:{
                    confirm: {
                        text : 'OK',
                        className : 'btn btn-success'
                    }   
                }
                }).then((Delete) => {
                    if (Delete) {
                        window.location.href="dashboard"
                    } 
                });
            }
        }
    })
})
//invoice autocomplete
$(document).ready(function(){
    $('#search_invoice').autocomplete({
        source: function( request, response ) {
        // Fetch data
        
        $.ajax({
            url:'srinvautocomplete',
            type: 'post',
            dataType: "json",
            data: {
                _token:$('meta[name="csrf-token"]').attr('content'),
                term: request.term
            },
            success: function( data ) {
            response( data );
/*             console.log(data) */
            }
        });
        },
        select: function (event, ui) {
            $('#search_invoice').val(ui.item.value);

            return false;
        }
    })
})
$(document).on('click','#btn_search',function(){
    var invoice = $('#search_invoice').val();
    showinvoiceprint(invoice);
})
function showinvoiceprint(invoice)
{
    var invoice_no=invoice
    $.ajax({
        method:'post',
        url:'invoiceprint',
        data:{
            invoice:invoice_no,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#printinvoice').html(res);
            $('#invoice').modal('show');
            $('#searchinvoicesmodal').modal('hide');
            $(this).closest('.modal').modal('hide');
          
          //console.log(res)

        }
    })
}
function myFunction() {
    document.getElementById("pyment_amount").select();
}
//hold invoices
$('#hold_invoice').on('click',function(e){
    e.preventDefault();
    var cust_id=$('#cust_data').children("option:selected").val();
    var order_total=parseInt($("#order_total").text());
    var net_payable=parseInt($("#net_payable").text());
    var discount_amount=parseInt($("#discount_amount").text());
    var payment_amount=parseInt($("#pyment_amount").val());
    var change_amount=parseInt($("#change_amount").val());
    var invoice_no=$('#invoice_no').val();

    swal({
        icon: "info",
        title: 'Are you sure?',
        text: "Do you really want to hold this invoice!",
        type: 'warning',
        buttons: {
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            },
            confirm: {
                text: 'Yes,Hold it!',
                className: 'btn btn-success'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            $.ajax({
                url:'holdinvoice',
                method:'post',
                data:{
                    cust_id:cust_id,
                    order_total:order_total,
                    net_payable:net_payable,
                    discount_amount:discount_amount,
                    payment_amount:payment_amount,
                    change_amount:change_amount,
                    invoice_no:invoice_no,
                    _token:$('meta[name="csrf-token"]').attr('content'),
                },
                success:function(res){
        
                    if(res.status==200)
                    {     
                        generateinvoice();
                        emptycart();
                        loadcart();
                        reset();
/*                         invoiceprint(invoice_no); */
                    }
                    else if(res.status==202)
                    {
                        swal("Warning!", "Cart is empty you cannot hold it. ", {
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
        }
    })
})

// hold invoice lists
$(document).on('click','#btnholdinvoice',function(){
    $.ajax({
        url:'holdinvoiceslist',
        method:'get',
        success:function(res){
            $('#show_hold_invoices').html(res);
            $('#hold_inv_list').DataTable({
                "pageLength": 5,
            });
        }
    })
})

// invoices
$(document).on('click','.viewholdinvoice',function(){
    let invoice_no=$(this).attr('id');
    invoiceholdprint(invoice_no);
})
function invoiceholdprint(invoice)
{
var invoice_no=invoice
$.ajax({
    method:'post',
    url:'invoiceprint',
    data:{
        invoice:invoice_no,
        _token:$('meta[name="csrf-token"]').attr('content'),
    },
    success:function(res)
    {
      $('#printholdinvoice').html(res);
      $('#holdinvoicelist').modal('show');
      //console.log(res)

    }
})
}
//inline changing in the table
$(document).on('dblclick','#pos_table tbody tr',function()
{
    var id=$(this).attr('id');
    var avl_qty=$(this).find('td:eq(1) small');
    console.log(avl_qty.text())
    var $input = $('<input>', {
        value: avl_qty.text(),
        id:"newinput",
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
                $input.value=avl_qty.text();
            }else{
                $.ajax({
                    url:'posinlinechange',
                    method:'post',
                    data:{
                        id:id,
                        qty:qty,
                        _token:$('meta[name="csrf-token"]').attr('content'),
                    },
                    success:function(res)
                    {
                        console.log(res)
                        if(res.status==200)
                        {
                            loadcart();     
                        }else if(res.status==201)
                        {
                            swal("Warning!", "This quantity cannot be greater than the stock quantity. ", {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                            $input.value=avl_qty.text();
                        }
                    }
                })
                // return_qty.text(this.value);
            }
        },
        keyup: function(e) {
        if (e.which === 13) $input.blur();
        
        }
    }).appendTo( avl_qty.empty() ).focus().select();
})
// add in cart
$(document).on('click','.plus-cart',function(e){
    e.preventDefault();
    let prod_id=$(this).attr('id');
    $.ajax({
        method:'get',
        url:'plusincart',
        data:
        {
            id:prod_id,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadcart();
            }
            $('#prod_id').val("");

        }

    })

})
// minus from cart
$(document).on('click','.minus-cart',function(e){
    e.preventDefault();
    let prod_id=$(this).attr('id');
    $.ajax({
        method:'get',
        url:'minusfromcart',
        data:
        {
            id:prod_id,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadcart();
            }
            $('#prod_id').val("");

        }

    })

})
// Load Hold Invoice
$(document).on('click','.editholdinvoice',function(e){
    e.preventDefault();
    let invoice_no=$(this).attr('id');
    $.ajax({
        method:'post',
        url:'loadholdinvoice',
        data:
        {
            invoice_no:invoice_no,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            if(res.status===200)
            {
                loadcart();
                $('#cust_data').val(res.sale.cust_id);
                fetchcust_info();
                $('#pyment_amount').val(res.sale.payment_amount);
                $('#discount_amount').html(res.sale.discount);
                $('#discount_textbox').val(res.sale.discount);

            }

        }

    })

})


//unique validation
function uniquevalidation(input_id,route,div_id,message_id,form_btn_id){
    $(input_id).on('blur',function(){
      if($(input_id).val()!=="")
      {
        var input_data=$(input_id).val();
        $.ajax({
          url:route,
          method:'post',
          data:{
            input_data:input_data,
            _token:$('meta[name="csrf-token"]').attr('content'),
          },
          success:function(res){
            // console.log($(input_id).val())
            if(res==400){
              $(message_id).removeClass('text-success');
              $(div_id).removeClass('has-success');
              $(message_id).addClass('text-danger');
              $(div_id).addClass('has-error');
              $(div_id).addClass('has-feedback');
              $(message_id).html("This input value already exists in the record .");
              $(form_btn_id).prop('disabled', true);
            }
            else
            {
              $(message_id).removeClass('text-danger');
              $(div_id).removeClass('has-error');
              $(div_id).removeClass('has-feedback');
              $(message_id).addClass('text-success');
              $(div_id).addClass('has-success');
              $(message_id).html("Validated input value .");
              $(form_btn_id).prop('disabled', false);
            }
          }
        })
      }
      else{
        $(message_id).removeClass('text-danger');
        $(div_id).removeClass('has-error');
        $(div_id).removeClass('has-feedback');
        $(message_id).removeClass('text-success');
        $(div_id).removeClass('has-success');
        $(message_id).addClass('text-danger');
        $(message_id).html("");
        $(form_btn_id).prop('disabled', false);
      }
    })
  
  }
//unique validation for key up
function keyupuniquevalidation(input_id,route,div_id,message_id,form_btn_id)
{
    $(input_id).on('keyup',function(){
      if($(input_id).val()!=="")
      {
        var input_data=$(input_id).val();
        $.ajax({
          url:route,
          method:'post',
          data:{
            input_data:input_data,
            _token:$('meta[name="csrf-token"]').attr('content'),
          },
          success:function(res){
            // console.log($(input_id).val())
            if(res==400){
              $(message_id).removeClass('text-success');
              $(div_id).removeClass('has-success');
              $(message_id).addClass('text-danger');
              $(div_id).addClass('has-error');
              $(div_id).addClass('has-feedback');
              $(message_id).html("This input value already exists in the record .");
              $(form_btn_id).prop('disabled', true);
            }
            else
            {
              $(message_id).removeClass('text-danger');
              $(div_id).removeClass('has-error');
              $(div_id).removeClass('has-feedback');
              $(message_id).addClass('text-success');
              $(div_id).addClass('has-success');
              $(message_id).html("Validated input value .");
              $(form_btn_id).prop('disabled', false);
            }
          }
        })
      }
      else{
        $(message_id).removeClass('text-danger');
        $(div_id).removeClass('has-error');
        $(div_id).removeClass('has-feedback');
        $(message_id).removeClass('text-success');
        $(div_id).removeClass('has-success');
        $(message_id).addClass('text-danger');
        $(message_id).html("");
        $(form_btn_id).prop('disabled', false);
      }
    })
}

//<--------------------------------- invoice material--------------------------------->

$('#frm_inv_config').submit(function(e){
    e.preventDefault();
    var fd=new FormData(this);
    $('#add_inv_config_btn').text('Saving...');
    $("#add_inv_config_btn").prop('disabled', true);
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
        url:'addinvoicematerial',
        method:'post',
        data:fd,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".progress-bar").width('0%');
        },
        success:function(res)
        {
            if(res.status===200)
            {
                $(".progress-bar").width('0%');
                swal(
                    'Success!',
                    'Configuration has been saved successfully',
                    'success'
                )
                $("#logoview").html("");
                $('#add_inv_config_btn').text('Save');
                $("#add_inv_config_btn").prop('disabled', false);
                $('#frm_inv_config')[0].reset();
                $('#invoiceitems').modal('hide');
            }
            loaddetails();
        }
    })
})

$(function () {
    $("#invoicelogo").change(function () {
        $("#logoview").html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        if (regex.test($(this).val().toLowerCase())) {
           
                if (typeof (FileReader) != "undefined") {
                    $("#logoview").show();
                    $("#logoview").html("<img />");
                    $("#logoview img").addClass('avatar-img rounded');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#logoview img").attr("src", e.target.result);
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

$('#btn_sale_inv').on('click',function(e){
  e.preventDefault();
  loaddetails();
})

function loaddetails()
{
    $.ajax({
        url:'getinvdetail',
        method:'get',
        success:function(res)
        {
            if(res.lnguage=="English")
            {
                $('#English').prop("checked", true);
            }else if(res.language=="urdu")
            {
                $('#urdu').prop("checked", true);  
            }
            else if(res.language=="urduenglish")
            {
                $('#urduenglish').prop("checked", true);
            }
            $('#logoview').html(res.img);
        }
    })
}
// Remove image
$(document).on('click','#remove_img',function(e){
    e.preventDefault();
    swal({
		icon : "info",
		title: 'Are you sure?',
		text: "Logo will be permanently deleted.",
		type: 'warning',
		buttons:{
			cancel: {
				visible: true,
				className: 'btn btn-danger'
			},confirm: {
				text : 'Yes, delete it!',
				className : 'btn btn-success'
			}
		}
        }).then((Delete) => {
          if (Delete) 
          {
            $.ajax({
                url:'delinvlogo',
                method:'get',
                success:function(res)
                {
                    if(res.status==200)
                    {
                        swal(
                            'Success!',
                            'Logo has been removed successfully',
                            'success'
                        )
                        $("#logoview").html("");
                        $('#frm_inv_config')[0].reset();
                        $('#invoiceitems').modal('hide');
                    }
                }
            })
        }
    })    
})


//<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

function previousbalance(cust_id)
{
    $.ajax({
        url:'loadpreviousbalance',
        method:'get',
        data:{
            cust_id:cust_id,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res){
          if(res){
            $('#sal_prev_bal').html(res);
          }else{
            $('#sal_prev_bal').html("00");
          }
          cal_netpayable()
        }
    })
}

//onchange load balance
$('#cust_data').on('change',function(e){
    e.preventDefault();
    var cust_id=$(this).val();
    previousbalance(cust_id);
})


//enter press event

$('#pyment_amount').keyup(function(e){
    if (e.which === 13)
    {
        $('#btn_checkout').click();
    }
})