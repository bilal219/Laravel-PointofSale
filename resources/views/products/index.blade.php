@extends('layouts.master')
@section('content')
<div class="content">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Products</h4>
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
          <a href="#">Products</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Add New Product</h4>
              <button class="btn btn-primary btn-round ml-auto" id="addcustomer" data-toggle="modal" data-target="#addproductModal">
                <i class="fa fa-plus"></i>
                New Product
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" id="show_all_products">	
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Add Product Modal -->
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
                <label for="phone">Cost Price&nbsp;<strong class="text-danger">*</strong>/label>
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
                <input type="number" name="reorder_qty" id="reorder" class="form-control form-control-sm" placeholder="Opening Quantity" required >
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
              <div class="col-lg">
                  <label for="avatar">Select Image</label>
                  <input type="file" name="product_image" class="form-control" id="fileupload">
              </div>
              <div class="col-lg">
                  <div id="dvPreview" class="avatar avatar-xxl">
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

<!--Edit Product Modal -->
<div class="modal fade bd-example-modal-lg" id="editproductModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="small text-danger">Fields Name with * are mendatory</p>
				<form id="edit_product_form">
          @csrf
          <input type="hidden" name="pro_id" id="pro_id">
          <div class="row">
            <div class="col-lg">
              <label for="emp_name">Product Name&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="product_name" id="product_name" class="form-control form-control-sm" placeholder="Product Name" required onkeyup="editsecondName()">
            </div>
            <div class="col-lg">
              <label for="email">Second Name</label>
              <input type="text" name="generic_name" id="generic_name" class="form-control form-control-sm" placeholder="Second Name">
            </div>
          </div>
          <div class="my-2 row">
            <div class="col-lg">
              <input type="checkbox" name="autobarcode" checked id="edit_chkbarcode"><small>&nbsp;&nbsp;Generate Auto Barcode&nbsp;<strong class="text-danger">*</strong></small>
              <input type="number" name="upc_ean" class="form-control form-control-sm edit_upc_ean" required placeholder="Barcode">
            </div>
            <div class="col-lg">
              <input type="checkbox" name="apply_expiry"  id="edit_apply_expiry"><small>&nbsp;&nbsp;Apply Expiry&nbsp;<strong class="text-danger">*</strong></small>
              <input type="date" name="expiry_date" id="edit_expiry_date" class="form-control form-control-sm" required readonly id="expiry_date">
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="squareSelect">Category&nbsp;<strong class="text-danger">*</strong></label>
              <div class="d-flex">
                <select class="form-control form-control-sm" id="editCategory" required name="cat_id">
                  <!-- ajax rendering -->
                </select>                          
                <a href="" id="addtype"  data-toggle="modal" data-target="#addCategoryModal" class="mx-1 btn btn-success btn-sm btn-link fa fa-plus"></a>
              </div>                           
            </div>
            <div class="col-lg">
              <label for="squareSelect">UOM&nbsp;<strong class="text-danger">*</strong></label>
              <div class="d-flex">
                <select class="form-control form-control-sm" id="edituom" required name="uom_id">
                  <!-- ajax rendering -->
                </select>                           
                <a href="" id="addarea" data-toggle="modal" data-target="#adduomModal" class="mx-1 btn btn-success btn-sm btn-link fa fa-plus"></a> 
              </div>                           
            </div>
          </div>
          <input type="checkbox" name="dont_stock_manage" class="my-2" id="edit_stock_manage"><small>&nbsp;&nbsp;Don't Manage Stock</small>
          <div class="row">
            <div class="col-lg my-2">
              <label for="contact">Opening Quantity&nbsp;<strong class="text-danger">*</strong></label>
              <input type="number" name="opening_qty" id="edit_opening_qty" class="form-control form-control-sm" placeholder="Opening Quantity" required>
              <small class="text-danger" id="edit_qty_error_msg"></small>
            </div>
            <div class="col-lg my-2">
              <label for="phone">Cost Price&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="edit_cost_price" id="edit_cost_price" class="form-control form-control-sm" placeholder="Cost Price" required>
              <small class="text-danger" id="edit_cost_error_msg"></small>

            </div>
          </div>
          <div class="row">
            <div class="col-lg my-2">
              <label for="contact">Retail Price&nbsp;<strong class="text-danger">*</strong></label>
              <input type="number" name="retail_price" id="edit_retail_price" class="form-control form-control-sm" placeholder="Retail Price" required>
              <small class="text-danger" id="edit_retail_error_msg"></small>
            </div>
            <div class="col-lg my-2">
              <label for="phone">Discount(%)</label>
              <input type="number" name="discount" id="edit_discount" class="form-control form-control-sm" placeholder="Discount(%)">
            </div>
            <div class="col-lg my-2">
              <label for="phone">Final Price</label>
              <input type="number" name="final_price" id="edit_final_price" class="form-control form-control-sm" placeholder="Final price" readonly>
              <small class="text-danger" id="edit_reorder_error_msg"></small>
            </div>
          </div>
          <div class="row">
            <div class="col-lg my-2">
              <label for="contact" class="m-1">Re Order Level&nbsp;<strong class="text-danger">*</strong></label>
              <input type="number" name="reorder_qty" id="edit_reorder" class="form-control form-control-sm" placeholder="Opening Quantity" required>
            </div>
            <div class="col-lg my-2">
              <input type="checkbox" name="supplier" class="my-2" id="edit_chk_supp"><small>&nbsp;&nbsp;Enable Supplier</small>
              <select class="form-control form-control-sm" id="edit_supp-list" name="supp_id" disabled>
                <option value="">--Select Supplier--</option>
                <!-- ajax rendering -->
              </select> 
            </div>
          </div> 
          <div class="row my-2"> 
            <div class="col-lg">
              <label for="avatar">Select Image</label>
              <input type="file" name="product_image" class="form-control" id="fileeditupload">
            </div>
            <div class="col-lg">
              <div id="dveditPreview" class="avatar avatar-xxl">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm" id="edit_product_btn">Update Product</button>	
        </div>
			</form>
		</div>
	</div>
</div>	
@endsection
@section('Scripts')
<script>
   fillcatadd();
   filluomadd();
   loadsuppliers();
   barcodecondition();
   $("#addCategoryModal").on('shown.bs.modal', function() {
        $("#addproductModal").css({ opacity: 0.3 });
        $("#editproductModal").css({ opacity: 0.3 });
        $('#catmodal-footer').addClass('bg-grey2');
        $('#catmodal-header').addClass('bg-grey2');
        $('#cat_modal').removeClass('modal-lg');
        $('#cat_modal').addClass('modal-dialog-centered');
        $('input[name=cat_name]').focus();
    });
    $('#addCategoryModal').on('hidden.bs.modal', function () {
      $("#addproductModal").css({ opacity: 1 });
      $("#editproductModal").css({ opacity: 1 });
        $('#catmodal-footer').removeClass('bg-grey2');
        $('#catmodal-header').removeClass('bg-grey2');
        $('#cat_modal').addClass('modal-lg');
        $('#cat_modal').removeClass('modal-dialog-centered');
    });
    //type
    $("#adduomModal").on('shown.bs.modal', function() {
        $("#addproductModal").css({ opacity: 0.3 });
        $("#editproductModal").css({ opacity: 0.3 });
        $('#uommodal-footer').addClass('bg-grey2');
        $('#uommodal-header').addClass('bg-grey2');
        $('#uom-modal').removeClass('modal-lg');
        $('#uom-modal').addClass('modal-dialog-centered');
        $('input[name=uom_name]').focus();
    });
    $('#adduomModal').on('hidden.bs.modal', function () {
      $("#addproductModal").css({ opacity: 1 });
      $("#editproductModal").css({ opacity: 1 });
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
    //barcode condtion on edit
    function barcodeonedit(){
      if($('#edit_chkbarcode').is(':checked'))
      {
        autogenbarcode();
        $(".edit_upc_ean").prop('readonly', true);
      }else if(!$('#edit_chkbarcode').is(':checked')){
        $(".edit_upc_ean").prop('readonly', false);
        $(".edit_upc_ean").val("");
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
    //check autobarcode
    $('#edit_chkbarcode').click(function(){
      barcodeonedit();
    })
    // function auto_gen_barcode
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
	//expiry edit check
	$('#edit_apply_expiry').click(function(){
    //If the checkbox is checked.
    if($(this).is(':checked')){
        //Enable the Expiry date field
        $('#edit_expiry_date').attr("readonly", false);
		document.getElementById("edit_expiry_date").value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("edit_expiry_date").min = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
    } else{
        //If it is not checked
        $('#edit_expiry_date').attr("readonly", true);
		document.getElementById("edit_expiry_date").value ="";
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
    //edit supplier check
	$('#edit_chk_supp').click(function(){
    //If the checkbox is checked.
    if($(this).is(':checked')){
      //Enable the Expiry date field
      $('#edit_supp-list').attr("disabled", false);
      } 
    else{
    //If it is not checked
    $('#edit_supp-list').attr("disabled", true);
    document.getElementById("edit_supp-list").value ="";
    }
    });

    //manage stock
    $('#stock_manage').click(function(){
    //If the checkbox is checked.
    managestock();
    });
    //edit manage stock
    $('#edit_stock_manage').click(function(){
    //If the checkbox is checked.
    editmanagestock();
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
    function editmanagestock()
    {
      if($('#edit_stock_manage').is(':checked')){
      //Enable the Expiry date field
      $('#edit_opening_qty').attr("disabled", true);
      $('#edit_reorder').attr("disabled", true);
      $('#edit_opening_qty').val(0);
      $('#edit_reorder').val(0);
      } 
    else{
      //If it is not checked
      $('#edit_opening_qty').attr("disabled", false);
      $('#edit_reorder').attr("disabled", false);
    }
    }

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
      // discount count on edit
      $("#edit_discount").on('keyup',function(){
        var retail=$("#edit_retail_price").val();
        var discount=$("#edit_discount").val();
        (retail==="" ||retail===0) ? retail=0:retail=parseInt(retail);
        (discount===""||discount===0) ? discount=0:discount=parseInt(discount);
        discount=((discount/100)*retail);
        var finalprice=retail-discount;
        $("#edit_final_price").val(finalprice);      
      })

      $("#edit_retail_price").on('keyup',function(){
        var retail=$("#edit_retail_price").val();
        var discount=$("#edit_discount").val();
        (retail==="" ||retail===0) ? retail=0:retail=parseInt(retail);
        (discount===""||discount===0) ? discount=0:discount=parseInt(discount);
        discount=((discount/100)*retail);
        var finalprice=retail-discount;
        $("#edit_final_price").val(finalprice);
      })
     // fetchproducts
     fetchproducts();

function fetchproducts() {
    $.ajax({
        url: '{{route('fetchproductlist')}}',
        method: 'get',
        success: function(res) {
            $('#show_all_products').html(res);
            $('#add-row').DataTable({
                "pageLength": 5,
            });
        }
    })
}
//edit product
$(document).on('click', '.editproducticon', function(e) {
  $('#edit_qty_error_msg').html('');
  $('#edit_cost_error_msg').html('');
  $('#edit_retail_error_msg').html('');
  $('#edit_reorder_error_msg').html('');
    e.preventDefault();
    let proid = $(this).attr('id');
    $.ajax({
        method: 'get',
        url: '{{route('editproduct')}}',
        data: {
            id: proid,
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
          if(res.expirydate)
          {
            $('#edit_apply_expiry').prop('checked',true)
            $('#edit_expiry_date').val(res.expirydate)
            $('#edit_expiry_date').attr("readonly", false);
          }
          if(res.manage_stock==="N")
          {
            $('#edit_stock_manage').prop('checked',true)
            editmanagestock();
          }
            // console.log(res);
          $('#pro_id').val(res.id);
          $('#product_name').val(res.product_name);
          $('#generic_name').val(res.generic_name);
          if(res.UPC_EAN)
          {
            $('#edit_chkbarcode').prop('checked',true)
            $('.edit_upc_ean').val(res.UPC_EAN);
            $(".edit_upc_ean").prop('readonly', true);
          }
          $("#dveditPreview").html('<img src="/assets/img/default.png" class="avatar-img rounded"/>');
          if(res.product_image)
          {
            $("#dveditPreview").html(`<img src="storage/images/product_images/${res.product_image}" 
            class="avatar-img rounded"/>`);
          }
          if(res.supp_id)
          {
            $('#edit_chk_supp').prop('checked',true);
            $('#edit_supp-list').attr("disabled",false);
            $('#edit_supp-list').val(res.supp_id);
          }else{
            $('#edit_chk_supp').prop('checked',false);
            $('#edit_supp-list').val("");
            $('#edit_supp-list').attr("disabled",true);
          }
          $('#editCategory').val(res.cat_id);
          $('#edituom').val(res.uom_id);
          $('#edit_opening_qty').val(res.qty);
          $('#edit_cost_price').val(res.costprice);
          $('#edit_retail_price').val(res.retailprice);
          $('#edit_discount').val(res.discount);
          $('#edit_final_price').val(res.fretailprice);
          $('#edit_reorder').val(res.reorder_qty);
          $('#edit_supp-list').val(res.supp_id);
        }
    });
})
//update Product data
$('#edit_product_form').submit(function(e) {
  e.preventDefault();
  let checkqty=true;
  let checkcost=true;
  let checkretail=true;
  let checkreorder=true;
  let qty=parseInt($('#edit_opening_qty').val())
  let cost=parseInt($('#edit_cost_price').val())
  let retail=parseInt($('#edit_retail_price').val())
  let reorder=parseInt($('#edit_reorder').val())
  if(qty<=0)
  {
    $('#edit_qty_error_msg').html('Quantity cannot be less than 1')
    checkqty=false;
  }
  else{
    $('#edit_qty_error_msg').html('')
    checkqty=true;
  }
  if(cost<=0)
  {
    $('#edit_cost_error_msg').html('Cost Price cannot be less than 0 or negative')
    checkcost=false;
  }
  else{
    $('#edit_cost_error_msg').html('')
    checkcost=true;
  }
  if(retail<=0)
  {
    $('#edit_retail_error_msg').html('Retail Price cannot be less than 0 or negative')
    checkretail=false;
  }else if(retail<cost)
  {
    $('#edit_retail_error_msg').html('Cost Price cannot be less than retail price')
    checkretail=false;
  }else{
    $('#edit_retail_error_msg').html('')
    checkretail=true;
  }
  if(reorder<0)
  {
    $('#edit_reorder_error_msg').html('Reorder quantity cannot be negative')
    checkreorder=false;
  }else{
    $('#edit_reorder_error_msg').html('')
    checkreorder=true;
  }
  if(checkqty && checkcost && checkretail && checkreorder)
  {
    const fd = new FormData(this);
    $('#edit_product_btn').text('Updating...');
    $("#edit_product_btn").prop('disabled', true);
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
        method: 'post',
        url: '{{route('updateproduct')}}',
        data: fd,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
         $(".progress-bar").width('0%');
        },
        success: function(res) {
          // console.log(res);
          $(".progress-bar").width('0%');
          if (res.status === 200) {
              $('#successsound').trigger('play')
              swal(
                'Updated!',
                'Product has been Updated successfully',
                'success'
              )
              fetchproducts();
              $('#edit_product_btn').text('Update Product');
              $("#edit_product_btn").prop('disabled', false);
              $('#edit_product_form')[0].reset();
              $("#dveditPreview").html("");
              $('#editproductModal').modal('hide');
          }
        }
    })
  }
})
//delete Product
$(document).on('click', '.deleteproducticon', function(e) {
    e.preventDefault();
    $('#warningsound').trigger('play');
    let proid = $(this).attr('id');
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
                text: 'Yes, delete it!',
                className: 'btn btn-success'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            $.ajax({
                method: 'post',
                url: '{{route('productdelete')}}',
                data: {
                    id: proid,
                    _token: '{{csrf_token()}}'
                },
                success: function(res) {
                    if (res.status === 200) {
                        $('#successsound').trigger('play')
                        swal(
                            'Deleted!',
                            'Product has been deleted successfully.',
                            'success'
                        )
                        fetchproducts();
                    }
                }

            })
        }
    })
})
      //add product
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
                fetchproducts();
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

function secondName()
{
  $('#gen_name').val('_'+$('#prod_name').val())
}
function editsecondName()
{
  $('#generic_name').val('_'+$('#product_name').val())
}
</script>
@endsection