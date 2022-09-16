    // ajax call here
    fetchallcustcat();
    loadcart();
    fetchcust_info();
    //fetchcustomer & categories
function fetchallcustcat(){
    $.ajax({
        url:"{{route('fetchall')}}",
        method:'post',
        success:function(res){
            $('#prod_cat').html(res.categories); 
            $('#cust_data').html(res.customers); 
            $('#prod_data').html(res.products);
        }
    })
}
//loadcart
function loadcart()
{
    $.ajax({
        url:"{{route('loadcart')}}",
        method:'post',
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
}
//category wise filter
function filterprods()
{
    var catid=$('#prod_cat').val();
$.ajax({
    method:'get',
    url:"{{route('fetchprods')}}",
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
    url:"{{route('fetchcustinfo')}}",
    data:{
    id:custid,
    _token:'{{csrf_token()}}'
    },
    success:function(res){
      $('#cust_name').val(res.cust_name);
      $('#cust_contact').val(res.contact);
    }
})
}

// getting product on search

$(document).ready(function () {
            
    var ProductName = this.value;
    $.ajax({
        url: "{{route('searchproducts')}}",
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
         url:"{{route('addtocart')}}",
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
        }
    })
})
// remove from cart
$(document).on('click','.delfromcarticon',function(e){
    e.preventDefault();
    let prod_id=$(this).attr('id');
    $.ajax({
        method:'get',
        url:"{{route('removefromcart')}}",
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
        }

    })

})
//calculate discount
function cal_netpayable()
{
    var order_total=parseInt($("#order_total").text());
    var discount=$('#discount_textbox').val();
    var payables=0;
    if ($("#percentradio").prop("checked"))
    { discount!=="" ? discount=(parseInt(discount)*order_total)/100 : discount=0;}
      
    (discount!=="" || discount!==0)? payables=(order_total-discount):payables=(order_total-0);
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
// fetch product infromation
function fetchpro_info()
{
    var proid=$('#productlist').children("option:selected").val();
    $.ajax({
    method:'get',
    url:"{{route('fetchproinfo')}}",
    data:{
    id:proid,
    _token:'{{csrf_token()}}'
    },
    success:function(res){
      $('#pro_name').val(res.product_name);
      $('#saleprice').val(res.retailprice);
    }
  });
} 

$(document).on('click','.addgridcart',function(e){
   e.preventDefault();
   let pro_id=$(this).attr('id');
   $.ajax({
        method:'post',
        url:"{{route('addcartgrid')}}",
        data:{
        id:pro_id,
        _token:'{{csrf_token()}}'
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
    var cust_id=$('#cust_data').children("option:selected").val();
    var order_total=parseInt($("#order_total").text());
    var net_payable=parseInt($("#net_payable").text());
    var discount_amount=parseInt($("#discount_amount").text());
    var payment_amount=parseInt($("#pyment_amount").val());
    var change_amount=parseInt($("#change_amount").val());
    $.ajax({
        url:"{{route('salecheckout')}}",
        method:'post',
        data:{
            cust_id:cust_id,
            order_total:order_total,
            net_payable:net_payable,
            discount_amount:discount_amount,
            payment_amount:payment_amount,
            change_amount:change_amount,
            _token:'{{csrf_token()}}'
        },
        success:function(res)
        {
            console.log(res)
        }

    })
})

    
