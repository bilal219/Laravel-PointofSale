@php
use App\Models\ClientDetails;
$rpt_data=ClientDetails::latest('id')->first();
@endphp
<style>
 .modal-body
 {
    background-color:#ffffff;
 }
</style>
<!--Add Category Modal -->
<div class="modal fade bd-example-modal-lg" id="addCategoryModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header" id="catmodal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_category_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg" id="cat_name_div">
                            <label for="fname">Category Name</label>
                            <input type="text" name="cat_name" class="form-control form-control-sm" placeholder="Category Name"
                            required id="prod_category_name">
                            <small id="cat_name_message" class="form-text"></small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer" id="catmodal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" id="add_category_btn">Add Category</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Add Area Modal -->
<div class="modal fade bd-example-modal-lg" id="addareaModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="area_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header" id="areamodal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_area_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg" id="cat_area_div">
                            <label for="fname">Area Name</label>
                            <input type="text" name="area_name" class="form-control form-control-sm" placeholder="Area Name" required id="area_name">
                            <small id="area_name_message" class="form-text"></small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer" id="areamodal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" id="add_area_btn">Add Area</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Add Type Modal -->
<div class="modal fade bd-example-modal-lg" id="addtypeModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="type_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header" id="typemodal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_type_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <label for="fname">Type</label>
                            <input type="text" name="type_name" class="form-control form-control-sm" placeholder="Type" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer" id="typemodal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" id="add_type_btn">Add Type</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- add UOM MOdal -->

<div class="modal fade bd-example-modal-lg" id="adduomModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" id="uom-modal">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header" id="uommodal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New UOM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_uom_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg" id="uom_name_div">
                            <label for="fname">UOM Name</label>
                            <input type="text" name="uom_name" class="form-control form-control-sm" placeholder="UOM Name" required id="prod_uom_name">
                            <small id="uom_name_message" class="form-text"></small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer" id="uommodal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" id="add_uom_btn">Add UOM</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- sale invoice modal -->
<div class="modal fade bd-example-modal-lg" id="invoice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sale Invoice :&nbsp;<small id="inv_no"></small></h5>
                <a class="btn btn-light text-capitalize border-0" id="printsalereciptbtn" data-mdb-ripple-color="dark"><i
                class="fas fa-print text-primary"></i> Print
                </a>
            </div>
            <div class="modal-body">
                <div id="printinvoice">

                    <!-- rendring -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div>

<!-- report modal -->
<div class="modal fade bd-example-modal-lg" id="reportmodal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;overflow-x: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal_name" id="exampleModalLabel">Report</h5>
                <a class="btn btn-light text-capitalize border-0" id="printrptbtn" data-mdb-ripple-color="dark"><i
                class="fas fa-print text-primary"></i> Print
                </a>
            </div>
            <div class="modal-body" id="printreport">
                <!-- rendring -->
                <center class="mt-3">
                    <h3><strong>{{$rpt_data->Bus_Name ?? 'Technic Mentors'}}</strong></h3>
                    <h5>{{$rpt_data->Bus_Address ?? 'Mumtaz Market Gujranwala'}}</h4>
                </center>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="panel panel-default">
                            <div class="panel-heading d-flex">
                                <h3 class="panel-title mx-auto"><strong><u id="rpt_name">Report Name</u></strong></h3>
                            </div>
                            <div class="d-flex">
                                <p ><strong id="rpt_param"></strong></p>
                                <p class="ml-auto">
                                    <strong id="rpt_from" class="mx-3"></strong>
                                    <strong id="rpt_to" class="mx-3"></strong>
                                </p>
                            </div>
                            <div class="panel-body mt--3">
                                <div class="table-responsive" id="rpt_body">
                                    
                                </div>
                            </div>
                            <div id="rpt_footer" class="my-4 d-flex">
                                <!-- //rendring footer info  -->
                            </div>
                            <div class="col-md-6 ml-auto mr-auto text-center mb-4" id="bus_msg">
                                                                    
                            </div>
                            <footer style="bottom:0;height:100%">
                                <center>
                                    <strong> Software Developed </strong><small>with love by</small><strong>Technic Mentors</strong>&nbsp;|&nbsp; 0300-4900046
                                </center>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>    
            </div>
        </div>
    </div>
</div>


<!-- sale return list modal -->
<div class="modal fade bd-example-modal-lg" id="return_detail_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return Detail&nbsp;<small id="inv_no"></small></h5>
                <!-- <a class="btn btn-light text-capitalize border-0" id="printbtn" data-mdb-ripple-color="dark">
                    <i class="fas fa-print text-primary"></i> Print
                </a> -->
            </div>
            <div class="modal-body">
                <div class="container" id="return_detail_view">
                    <!-- rendring -->
                 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div>

<!-- account payments -->
<div class="modal fade bd-example-modal-lg" id="account_payments_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal_name" id="exampleModalLabel">Payment Receipt</h5>
                <a class="btn btn-light text-capitalize border-0" id="printrcptbtn" data-mdb-ripple-color="dark"><i
                class="fas fa-print text-primary"></i> Print
                </a>
            </div>
            <div class="modal-body" id="printpayreceipt">
                <!-- rendring -->
                <center class="mt-3">
                    <h3><strong>{{$rpt_data->Bus_Name ?? 'Technic Mentors'}}</strong></h3>
                    <h5>{{$rpt_data->Bus_Address ?? 'Mumtaz Market Gujranwala'}}</h4>
                </center>
                <div class="row" id="pay_receipt">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>    
            </div>
        </div>
    </div>
</div>


<!-- customer -->

<!--Add Customer Modal -->
<div class="modal fade bd-example-modal-lg" id="addcustomerModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Customer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="small text-danger">Field names with * are mendatory</p>
				<form method="POST" id="add_customer_form">
				@csrf
          <div class="row">
            <div class="col-lg" id="div_cust_name">
                <label for="emp_name">Customer Name &nbsp;<strong class="text-danger">*</strong></label>
                <input type="text" name="cust_name" class="form-control form-control-sm" placeholder="Customer Name" id="customer_name" required>
                <small id="cust_name_message" class="form-text"></small>
            </div>
            <div class="col-lg">
                <label for="email">Father Name</label>
                <input type="text" name="fathername" class="form-control form-control-sm" placeholder="Father Name">
            </div>
          </div>
          <div class="my-2">
              <label for="email">E-mail</label>
              <input type="email" name="email" class="form-control form-control-sm" placeholder="E-mail">
          </div>
          <div class="row">
            <div class="col-lg" id="div_cust_contact">
              <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
              <input type="tel" name="contact" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" placeholder="Contact" required id="cust_contact">
              <small id="cust_contact_message" class="form-text"></small>
            </div>
            <div class="col-lg" id="div_cust_cnic">
              <label for="phone">CNIC</label>
              <input type="text" name="cnic" max="13" pattern="^\d{5}-\d{7}-\d{1}$" data-inputmask="'mask': '99999-9999999-9'"  placeholder="XXXXX-XXXXXXX-X" class="form-control form-control-sm" placeholder="CNIC" id="cust_cnic">
              <small id="cust_cnic_message" class="form-text"></small>
            </div>
          </div>
          <div class="my-2">
              <label for="phone">Address &nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="address" class="form-control form-control-sm" placeholder="Address" required>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="squareSelect">Customer Type</label>
              <div class="form-group d-flex">
                <select class="form-control form-control-sm" id="typecombobox" name="cust_type">
                  <!-- ajax rendering -->
                </select>                          
                <a href="" id="addtype"  data-toggle="modal" data-target="#addtypeModal" class="mx-1 btn btn-success btn-link fa fa-plus"></a>
              </div>                           
            </div>
            <div class="col-lg">
              <label for="squareSelect">Customer Area</label>
              <div class="form-group d-flex">
                <select class="form-control form-control-sm" id="areacombobox" name="cust_area">
                  <!-- ajax rendering -->
                </select>                           
                <a href="" id="addarea" data-toggle="modal" data-target="#addareaModal" class="mx-1 btn btn-success btn-link fa fa-plus"></a> 
              </div>                           
            </div>
          </div>
          <div class="row"> 
              <div class="col-lg">
                  <label for="avatar">Select Image</label>
                  <input type="file" name="cust_image" class="form-control form-control-sm" id="fileupload">
              </div>
              <div class="col-lg">
                  <div id="dvPreview" class="avatar avatar-xxl">
                  </div>
              </div>  
          </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-sm btn-primary" id="add_customer_btn">Add Customer</button>	
			</div>
			</form>
		</div>
	</div>
</div>

<!-- Dynamic Invoice Items -->

<div class="modal fade bd-example-modal-lg" id="invoiceitems" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header" id="catmodal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sale Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Sale Invoice Configuration</p>
                <form method="POST" id="frm_inv_config">
                    @csrf
                    <div class="row">
                        <div class="col-lg">
                            <div class="col-lg mb-2">
                                <h5>Invoice Language</h5>
                                <label class="form-radio-label ml-3 mb-2">
                                    <input class="form-radio-input" type="radio" id="English" value="English" name="inv_language" checked>
                                    <span class="form-radio-sign">English</span>
                                </label>
                                <br>
                                <label class="form-radio-label ml-3 mb-2">
                                    <input class="form-radio-input" type="radio" id="urdu" value="urdu" name="inv_language">
                                    <span class="form-radio-sign">اردو</span>
                                </label>
                                <br>
                                <!-- <label class="form-radio-label ml-3 mb-2">
                                    <input class="form-radio-input" type="radio" id="urduenglish" value="urduenglish" name="inv_language">
                                    <span class="form-radio-sign">English / اردو</span>
                                </label> -->
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="col-lg mb-2">
                                <h5>Invoice Logo</h5>
                                <label for="avatar">Select Image</label>
                                <input type="file" name="invoicelogo" class="form-control form-control-sm" id="invoicelogo">
                            </div>
                            <div class="col-lg">
                                <div id="logoview" class="avatar avatar-xxl float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="catmodal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="add_inv_config_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>