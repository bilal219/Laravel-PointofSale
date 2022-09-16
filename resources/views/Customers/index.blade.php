@extends('layouts.master')
@section('content')

<div class="content">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Customers</h4>
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
          <a href="#">Customer</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Add New Customer</h4>
              <button class="btn btn-primary btn-round ml-auto" id="addcustomer" data-toggle="modal" data-target="#addcustomerModal">
                <i class="fa fa-plus"></i>
                New Customer
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" id="show_all_customers">	
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!--Edit Customer Modal -->
<div class="modal fade bd-example-modal-lg" id="editcustomerModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small text-danger">Field names with * are mendatory</p>
                <form method="POST" id="edit_customer_form">
                @csrf
                <input type="hidden" name="cust_id" id="cust_id">
                <input type="hidden" name="customer_image" id="customer_image">
                <div class="row">
                    <div class="col-lg">
                        <label for="emp_name">Customer Name&nbsp;<strong class="text-danger">*</strong></label>
                        <input type="text" name="cust_name" id="cust_name" class="form-control form-control-sm" placeholder="Customer Name" required>
                    </div>
                    <div class="col-lg">
                        <label for="email">Father Name</label>
                        <input type="text" name="fathername" id="fathername" class="form-control form-control-sm" placeholder="Father Name">
                    </div>
                </div>
                <div class="my-2">
                  <label for="email">E-mail</label>
                  <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="E-mail">
                </div>
                <div class="row">
                  <div class="col-lg">
                    <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
                    <input type="tel" name="contact" id="contact" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" placeholder="Contact" required >
                  </div>
                  <div class="col-lg">
                    <label for="phone">CNIC</label>
                    <input type="text" name="cnic" id="cnic" max="13" pattern="^\d{5}-\d{7}-\d{1}$" data-inputmask="'mask': '99999-9999999-9'"  placeholder="XXXXX-XXXXXXX-X" class="form-control form-control-sm" placeholder="CNIC">
                  </div>
                </div>
                <div class="my-2">
                  <label for="phone">Address &nbsp;<strong class="text-danger">*</strong></label>
                  <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="Address" required>
                </div>
                <div class="row">
                  <div class="col-lg">
                      <label for="squareSelect">Customer Type</label>
                      <div class="form-group d-flex">
                          <select class="form-control form-control-sm" id="edittypecombobox" name="cust_type">
                            <!-- ajax rendering -->
                          </select>                          
                          <a href="" id="addtype" class="mx-1 btn btn-success btn-sm btn-link fa fa-plus"></a>
                      </div>                           
                  </div>
                  <div class="col-lg">
                    <label for="squareSelect">Customer Area</label>
                    <div class="form-group d-flex">
                        <select class="form-control form-control-sm" id="editareacombobox" name="cust_area">
                          <!-- ajax rendering -->
                        </select>                           
                        <a href="" id="addarea" data-toggle="modal" data-target="#addareaModal" class="mx-1 btn btn-sm btn-success btn-link fa fa-plus"></a> 
                    </div>                           
                  </div>
                </div>
                <div class="row">  
                  <div class="col-lg">
                      <label for="avatar">Select Image</label>
                      <input type="file" name="cust_image" class="form-control form-control-sm" id="fileeditupload">
                  </div>
                  <div class="col-lg">
                      <div id="dveditPreview" class="avatar avatar-xxl">
                      </div>
                  </div>  
                </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-sm btn-success" id="edit_customer_btn">Update Customer</button>	
                </div>
                </form>
            </div>
    </div>
</div>
	
		
@endsection
@section('Scripts')
   <script>
   
  //  area
    $("#addareaModal").on('shown.bs.modal', function() {
        $("#addcustomerModal").css({ opacity: 0.3 });
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
        $('#modal-footer').removeClass('bg-grey2');
        $('#modal-header').removeClass('bg-grey2');
        $('#area_modal').addClass('modal-lg');
        $('#area_modal').removeClass('modal-dialog-centered');
    });
    //type
    $("#addtypeModal").on('shown.bs.modal', function() {
        $("#addcustomerModal").css({ opacity: 0.3 });
        $("#editcustomerModal").css({ opacity: 0.3 });
        $('#typemodal-footer').addClass('bg-grey2');
        $('#typemodal-header').addClass('bg-grey2');
        $('#type_modal').removeClass('modal-lg');
        $('#type_modal').addClass('modal-dialog-centered');
        $('input[name=type_name]').focus();
    });
    $('#addtypeModal').on('hidden.bs.modal', function () {
      $("#addcustomerModal").css({ opacity: 1 });
      $("#editcustomerModal").css({ opacity: 1 });
        $('#typemodal-footer').removeClass('bg-grey2');
        $('#typemodal-header').removeClass('bg-grey2');
        $('#type_modal').addClass('modal-lg');
        $('#type_modal').removeClass('modal-dialog-centered');
    });
	   //modal open sound
	   $(document).on('click','#addcustomer',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetchemployees
       fetchallcustomers();
       fillareadd();
       filltypeadd();
		function fetchallcustomers()
		{
			$.ajax({
				url:'{{route('fetchcustomersdata')}}',
				method:'get',
				success:function(res){
					$('#show_all_customers').html(res);
					$('#fetch-customer').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}
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



    //edit area dropdown fill
    function fillareaedit(addid){
      $.ajax({
        url:'{{route('fetchareadata')}}',
        method:'get',
        success:function(res){
          output='<option value="">--Please select Customer Area--</option>';
          for(i=0;i<res.length;i++){
            if(res[i].id===addid){
              output +='<option value="'+res[i].id+'" selected>'+res[i].area+'</option>';
            }else{
              output +='<option value="'+res[i].id+'">'+res[i].area+'</option>';
            }
          }
          $('#editareacombobox').html(output); 
        }
      })
    }

     //edit type dropdown fill
    function filltypeedit(ddid){
      $.ajax({
        url:'{{route('fetchtypedata')}}',
        method:'get',
        success:function(res){
          output='<option value="">--Please select Customer type--</option>';
          for(i=0;i<res.length;i++){
            if(res[i].id===ddid){
              output +='<option value="'+res[i].id+'" selected>'+res[i].type+'</option>';
            }else{
              output +='<option value="'+res[i].id+'">'+res[i].type+'</option>';
            }
          }
          $('#edittypecombobox').html(output);
        }
        
      })
    }




		//edit Customers
		$(document).on('click','.editcustomericon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let custid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('editcustomer')}}',
         data:{
           id:custid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
         $("#cust_name").val(res.cust_name);
         $("#fathername").val(res.fathername);
          $("#address").val(res.address);
          $("#contact").val(res.contact);
          $("#cnic").val(res.cnic);
          $("#email").val(res.email);
          filltypeedit(res.type_id);
          fillareaedit(res.area_id);
          if(res.cust_image){
            $("#dveditPreview").html(`<img src="storage/images/cust_supplier_images/${res.cust_image}" 
            class="avatar-img rounded"/>`);
          }
          else{
            $("#dveditPreview").html(`<img src="{{asset('user.webp')}}" 
            class="avatar-img rounded"/>`);
          }
          $('#cust_id').val(res.id);
          $('#customer_image').val(res.cust_image);
          
         }
       });
     })
	  //delete employee
	  $(document).on('click','.deletecustomericon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let custid=$(this).attr('id');
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
				text : 'Yes, delete it!',
				className : 'btn btn-success'
			}
		}
        }).then((Delete) => {
          if (Delete) {
           $.ajax({
             method:'post',
             url:'{{route('customerdelete')}}',
             data:{
               id:custid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Customer Record has been deleted successfully.',
                 'success'
                 )
               fetchallcustomers();
               }
             }

           })
          }
        })
     })

	  //update customers data
	  $('#edit_customer_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_customer_btn').text('Updating...');
	   $("#edit_customer_btn").prop('disabled', true);
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
         method:'post',
         url:'{{route('updatecustomer')}}',
         data:fd,
         cache:false,
         processData:false,
         contentType:false,
         beforeSend: function(){
          $(".progress-bar").width('0%');
         },
         success:function(res){
          $(".progress-bar").width('0%');
          if(res.status===200)
          {
              $('#successsound').trigger('play')
                swal(
                  'Updated!',
                  'Customer record has been Updated successfully',
                  'success'
                )
                fetchallcustomers();
                $('#edit_customer_btn').text('Update Customer'); 
                $("#edit_customer_btn").prop('disabled', false);
                $('#edit_customer_form')[0].reset();
                $('#dveditPreview').html("");
                $('#editcustomerModal').modal('hide');
          }
                  
              
         }
       })
     })

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
						fetchallcustomers();
					$('#add_customer_btn').text('Add Customer');
					$("#add_customer_btn").prop('disabled', false);
					$('#add_customer_form')[0].reset();
          $('#dvPreview').html("")
					$('#addcustomerModal').modal('hide');
					}
		}

		})
		})
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
@endsection



