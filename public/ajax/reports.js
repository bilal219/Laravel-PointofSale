// <-------------------------Customer List--------------------------->
$(document).on('click','#printrptbtn',function(){
    $('#printreport').printThis();
})

//payment receipt print
$(document).on('click','#printrcptbtn',function(){
    $('#printpayreceipt').printThis();
})

getcustids()
function getcustids()
{
    $.ajax({
        url:'loadcust_id',
        method:'get',
        success:function(res)
        {
            $('#firstcustid').html(res.fst_dd);
            $('#lastcustid').html(res.lst_dd);
        }
    })
}

$('#print_cust_report').on('click',function(e){
e.preventDefault();
var from=$('#firstcustid').val();
var to=$('#lastcustid').val();
$.ajax({
    url:'fetchcustList',
    method:'post',
    data:{
        from:from,
        to:to,
        _token:$('meta[name="csrf-token"]').attr('content'),
    },
    success:function(res){
        $('#rpt_body').html(res.output);
        $('#rpt_from').html(`From Id# : &nbsp;${from}`);
        $('#rpt_to').html(`To Id#: &nbsp;${to}`);
        $('#rpt_name').html(res.rpt_name);
        $('#rpt_footer').html(`<strong>Total Customer :</strong>&nbsp;${res.total}`);
        $('#reportmodal').modal('show');
    }
})
})

// <---------------------------Supllier List------------------------->
//get supp_ids
function getsuppids()
{
    $.ajax({
        url:'loadsupp_id',
        method:'get',
        success:function(res)
        {
            $('#firstsuppid').html(res.fst_dd);
            $('#lastsuppid').html(res.lst_dd);
        }
    })
}

// Fetch Supplier List
$('#print_supp_report').on('click',function(e){
e.preventDefault();
var from=$('#firstsuppid').val();
var to=$('#lastsuppid').val();
$.ajax({
    url:'fetchsuppliers',
    method:'post',
    data:{
        from:from,
        to:to,
        _token:$('meta[name="csrf-token"]').attr('content'),
    },
    success:function(res){
        $('#rpt_body').html(res.output);
        $('#rpt_from').html(`From Id# : &nbsp;${from}`);
        $('#rpt_to').html(`To Id#: &nbsp;${to}`);
        $('#rpt_name').html(res.rpt_name);
        $('#rpt_footer').html(`<strong>Total Suppliers :</strong>&nbsp;${res.total}`);
        $('#reportmodal').modal('show');
    }

})
})

// <--------------------employee List---------------------->

//get supp_ids
function getempids()
{
    $.ajax({
        url:'loademp_id',
        method:'get',
        success:function(res)
        {
            $('#firstempid').html(res.fst_dd);
            $('#lastempid').html(res.lst_dd);
        }
    })
}

//get employee Report
$('#print_emp_report').on('click',function(e){
    e.preventDefault();
    var from=$('#firstempid').val();
    var to=$('#lastempid').val();
    $.ajax
    ({
        url:'fetchemployees',
        method:'post',
        data:
        {
            from:from,
            to:to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_from').html(`From Id# : &nbsp;${from}`);
            $('#rpt_to').html(`To Id#: &nbsp;${to}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`<strong>Total Employees :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

// <------------------------products list-------------------------->

function getcategories()
{
    $.ajax({
        url:'loadcat_id',
        method:'get',
        success:function(res)
        {
            $('#prod_cat_id').html(res);
        }
    })
}

//get Product Report
$('#print_prod_report').on('click',function(e){
    e.preventDefault();
    var cat=null;
    if($("#cat_prod:checked").val()) {
        cat=$('#prod_cat_id').val();
	}
    $.ajax
    ({
        url:'fetchproducts',
        method:'post',
        data:
        {
            category:cat,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(cat)
            {
                $('#rpt_param').html(`Category : &nbsp;${$("#prod_cat_id option:selected").text()}`);
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`<strong>Total Products :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

// <------------------------Stock Movement------------------------>

//get Stock Movement Report
$('#print_stockmovement_report').on('click',function(e){
    e.preventDefault();
    var from=$('#stock_rpt_dtp_from').val();
    var to=$('#stock_rpt_dtp_to').val();
    var status=$('#stock_status').val();
    $.ajax
    ({
        url:'fetchstock',
        method:'post',
        data:
        {
            from:from,
            to:to,
            status:status,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`Status : &nbsp;${status}`);
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`<strong>Total Products :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

//<----------------Below Order Report----------------------->

//get Below Order Report
$('#blw_order_btn').on('click',function(e){
    e.preventDefault();
   
    $.ajax
    ({
        url:'fetchreorder',
        method:'get',
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`<strong>Total Reorder Products :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

//<-----------------------Expired products-------------------->

//get Expired Products Report
$('#expr_products_btn').on('click',function(e){
    e.preventDefault();
   
    $.ajax
    ({
        url:'fetchexpire',
        method:'get',
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`<strong>Total Expired Products :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

//<--------------------------Customer Account Report-------------------------->

function getcustomers()
{
    $.ajax({
        url:'loadcust_acc_id',
        method:'get',
        success:function(res)
        {
            $('#cust_acc_id').html(res);
        }
    })
}

//get Customer Account Report
$('#print_cust_acc_report').on('click',function(e){
    e.preventDefault();
    var customer=null;
    var customer_name='All Customers';
    var route_url='fetchcustaccount';
    var from=$('#cust_acc_dtp_from').val();
    var to=$('#cust_acc_dtp_to').val();
    if($("#sngl_cust:checked").val()) {
        route_url='fetchsinglecustaccount';
        customer=$('#cust_acc_id').val();
        customer_name=$("#cust_acc_id option:selected").text();
	}else  if($("#all_cust:checked").val()){
        customer=null;
        from="";
        to="";
    }
    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            customer:customer,
            from:from,
            to:to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`Customer : &nbsp;${customer_name}`);
            if(customer)
            {
                $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
                $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            }
            else{
                $('#rpt_from').html("");
                $('#rpt_to').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})



//<------------------------------Supplier Account Report----------------------------->

//get supplier Account Report
$('#print_supp_acc_report').on('click',function(e){
    e.preventDefault();
    var supplier=null;
    var supplier_name='All Suppliers';
    var route_url='fetchsuppaccount';
    var from=$('#supp_acc_dtp_from').val();
    var to=$('#supp_acc_dtp_to').val();
    if($("#sngl_supp:checked").val()) {
        route_url='fetchsinglesuppaccount';
        supplier=$('#supp_acc_id').val();
        supplier_name=$("#supp_acc_id option:selected").text();
	}else{
        supplier=null;
        from="";
        to="";
    }
    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            supplier_id:supplier,
            from:from,
            to:to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`Supplier : &nbsp;${supplier_name}`);
            if(supplier!=null)
            {
                $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
                $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            }
            else{
                $('#rpt_from').html("");
                $('#rpt_to').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})


// <-----------------------Employee Account report------------------------>

//get supplier Account Report
$('#print_emp_acc_report').on('click',function(e){
    e.preventDefault();
    var employee=null;
    var employee_name='All Employees';
    var route_url='fetchempaccount';
    var from=$('#emp_acc_dtp_from').val();
    var to=$('#emp_acc_dtp_to').val();
    if($("#sngl_emp:checked").val()) {
        route_url='fetchsingleempaccount';
        employee=$('#emp_acc_id').val();
        employee_name=$("#emp_acc_id option:selected").text();
	}else{
        employee=null;
        from="";
        to="";
    }
    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            emp_id:employee,
            from:from,
            to:to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`Employee : &nbsp;${employee_name}`);
            if(employee!=null)
            {
                $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
                $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            }
            else{
                $('#rpt_from').html("");
                $('#rpt_to').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    
    })
})

// <---------------------------------All User Sales----------------------------->

$('#print_all_user_sale_report').on('click',function(e){

    e.preventDefault();
    route_url="fetchsales";
    var from=$('#sale_dtp_from').val();
    var to=$('#sale_dtp_to').val();
    if($("#sale_detail:checked").val()) 
    {
        route_url='fetchsaledetails';
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            from:from,
            to:to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html('User : All Users');
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})
            
// <----------------------Single User sale------------------------> 
            
            
$('#print_sngl_user_sale_report').on('click',function(e){

    e.preventDefault();
    route_url="fetchsinglesales";
    var from=$('#single_sale_dtp_from').val();
    var to=$('#single_sale_dtp_to').val();
    var user=$("#single_sale_user_id").val();
    var user_name=$("#single_sale_user_id option:selected").text();

    if($("#single_sale_detail:checked").val()) 
    {
        route_url='fetchsinglesaledetails';
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            from:from,
            to:to,
            user:user,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`User : &nbsp;${user_name}`);
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})


//  <---------------------------Sale return report--------------------------->

$('#sale_return_report').on('click',function(e){

    e.preventDefault();
    route_url="fetchsalereturn";
    var from=$('#sl_rtn_from').val();
    var to=$('#sl_rtn_to').val();
    var product=null;
    var prod_name=$("#sale_rtn_prods option:selected").text();
    
    if($("#dt_prd_sl_rtn:checked").val()) 
    {
        route_url='fetchprodsalereturn';
        product=$("#sale_rtn_prods").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            from:from,
            to:to,
            product:product,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(product)
            {
                $('#rpt_param').html(`Product : &nbsp;${prod_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})


// <---------------------------Profit Loss Report-------------------------------->

//load data
function loadprofitloss()
{
    var dtp_from=$('#pft_lss_from').val();
    var dtp_to=$('#pft_lss_to').val();
    var route_url="fetchprofitloss";
    $.ajax({
        url:route_url,
        method:'post',
        data:{
            from:dtp_from,
            to:dtp_to,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            var net_profit=parseInt(res.profit)-parseInt(res.expences)
            if(res.profit)
            {
                $('#sale_profit').html(res.profit);
            }else{
                $('#sale_profit').html(0);
            }
            if(res.expences)
            {
                $('#total_expences').html(res.expences);
            }else{$('#total_expences').html(0);}
            if(net_profit)
            {
                $('#net_profit').html(net_profit);
            }else{$('#net_profit').html(0);}
        }
    })
}

//show report

$('#profit_loss_report').on('click',function(){

    var from=$('#pft_lss_from').val();
    var to=$('#pft_lss_to').val();
    var report_body=`<hr style="height:1px;background: black;">
    <div class="mx-4">
        <h4 class="mb-1"><b> Sale Profit</b></h4>
        <h5 class="mb-2" id="sale_profit">${$('#sale_profit').text()}</h5>
        <h4 class="mb-1"><b> Total Expences</b></h4>
        <h5 class="mb-2" id="total_expences">${$('#total_expences').text()}</h5>
        <h3 class="mb-1"><b> Net Profit</b></h4>
        <h4 class="mb-2 font-weight-bold" id="net_profit">${$('#net_profit').text()}</h5>
    </div>
    <hr style="height: 1px;background: black;">`;
    $('#rpt_name').html("Profit / Loss Report");
    $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
    $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
    $('#rpt_body').html(report_body);
    $('#reportmodal').modal('show');

})


// <-----------------------------Cheque List----------------------------->

$('#chq_list_rpt_btn').on('click',function(e){

    e.preventDefault();
    route_url="fetchcheques";
    var from=$('#chq_from').val();
    var to=$('#chq_to').val();
    var status=$("#cheque_status").val();
    var status_name=$("#cheque_status option:selected").text();
    
    if($("#chq_supplier:checked").val()) 
    {
        route_url='fetchsuppliercheques';
	}
    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            from:from,
            to:to,
            status:status,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            $('#rpt_param').html(`Status : &nbsp;${status_name}`);
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})

// <-------------------------------Expence List Report--------------------------------->

$('#print_exp_report').on('click',function(e){

    e.preventDefault();
    route_url="fetchexpense";
    var from=$('#exp_from').val();
    var to=$('#exp_to').val();
    var cat=null;
    var cat_name=$("#exp_cat option:selected").text();
    
    if($("#cat_exp:checked").val()) 
    {
        route_url='fetchcatexpense';
        cat=$("#exp_cat").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            from:from,
            to:to,
            cat_id:cat,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(cat)
            {
                $('#rpt_param').html(`Category : &nbsp;${cat_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_from').html(`From : &nbsp;${moment(from).format('DD-MMM-YYYY')}`);
            $('#rpt_to').html(`To : &nbsp;${moment(to).format('DD-MMM-YYYY')}`);
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})

// <--------------------------Bussiness Capital------------------------------>

$('#b_capital').on('click',function(e){

    e.preventDefault();
    route_url="fetchcapital";
    $.ajax
    ({
        url:route_url,
        method:'get',
        success:function(res)
        {
            $('#rpt_body').html(res);
            $('#rpt_name').html("Business Capital");
            $('#reportmodal').modal('show');
        }
    })
})

//<----------------------------Customer receivables--------------------------->

$('#print_cust_rec').on('click',function(e){

    e.preventDefault();
    route_url="fetchallreceivale";
    var cust=null;
    var cust_name=$("#cust_rec option:selected").text();
    
    if($("#sngl_rec:checked").val()) 
    {
        route_url='fetchcustreceivable';
        cust=$("#cust_rec").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            cust_id:cust,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(cust)
            {
                $('#rpt_param').html(`Customer : &nbsp;${cust_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})

//<----------------------------Customer payables--------------------------->

$('#print_cust_pay').on('click',function(e){

    e.preventDefault();
    route_url="fetchallpayables";
    var cust=null;
    var cust_name=$("#cust_pay option:selected").text();
    
    if($("#sngl_pay:checked").val()) 
    {
        route_url='singlepayable';
        cust=$("#cust_pay").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            cust_id:cust,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(cust)
            {
                $('#rpt_param').html(`Customer : &nbsp;${cust_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})

// <----------------------------Supplier Payables---------------------------->

$('#print_supp_pay').on('click',function(e){

    e.preventDefault();
    route_url="fetchsupplierpayable";
    var supp=null;
    var supp_name=$("#supp_pay option:selected").text();
    
    if($("#sngl_supp_pay:checked").val()) 
    {
        route_url='singlesupplierpayable';
        supp=$("#supp_pay").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            supp_id:supp,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(supp)
            {
                $('#rpt_param').html(`Supplier : &nbsp;${supp_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})

//<----------------------------- Customer Balance---------------------------->

$('#print_cust_bal').on('click',function(e){

    e.preventDefault();
    route_url="fetchbalances";
    var cust=null;
    var cust_name=$("#cust_bal option:selected").text();
    
    if($("#sngl_bal:checked").val()) 
    {
        route_url='fetchcustbalances';
        cust=$("#cust_bal").val();
	}

    $.ajax
    ({
        url:route_url,
        method:'post',
        data:
        {
            cust_id:cust,
            _token:$('meta[name="csrf-token"]').attr('content'),
        },
        success:function(res)
        {
            $('#rpt_body').html(res.output);
            if(cust)
            {
                $('#rpt_param').html(`Customer : &nbsp;${cust_name}`);
            }else{
                $('#rpt_param').html("");
            }
            $('#rpt_name').html(res.rpt_name);
            $('#rpt_footer').html(`${res.rpt_footer}<strong class="ml-auto">Total Records :</strong>&nbsp;${res.total}`);
            $('#reportmodal').modal('show');
        }
    })
})