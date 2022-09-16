@extends('layouts.master')
@section('content')
<div class="content">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Suppliers</h4>
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
          <a href="#">Suppliers</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Add New Supplier</h4>
              <button class="btn btn-primary btn-round ml-auto" id="addcustomer" data-toggle="modal" data-target="#addsupplierModal">
                <i class="fa fa-plus"></i>
                New Supplier
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" id="show_all_suppliers">	
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Add Supplier Modal -->
<div class="modal fade bd-example-modal-lg" id="addsupplierModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="progress" style="height: 3px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%">
        </div>
      </div>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="add_supplier_form" enctype="multipart/form-data">
        <div class="modal-body">
        <p class="small text-danger">Field names with * are mendatory</p>
          @csrf
          <div class="my-2"> 
              <input type="checkbox" name="alsocust"><strong class="mx-2">Also a Customer</strong> 
          </div>
          <div class="row">
            <div class="col-lg">
                <label for="emp_name">Company Name&nbsp;<strong class="text-danger">*</strong></label>
                <input type="text" name="comp_name" class="form-control form-control-sm" placeholder="Company Name" required>
            </div>
            <div class="col-lg">
                <label for="email">Agency Name</label>
                <input type="text" name="agencyname" class="form-control form-control-sm" placeholder="Agency Name">
            </div>
          </div>
          <div class="my-2">
              <label for="email">Supplier Name&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="supp_name" class="form-control form-control-sm" placeholder="Supplier name" required>
          </div>
          <div class="row">
            <div class="col-lg">
                <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
                <input type="tel" name="contact" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" minlength="11" class="form-control form-control-sm" placeholder="Contact" required>
            </div>
            <div class="col-lg">
                <label for="phone">E-mail</label>
                <input type="email" name="email" class="form-control form-control-sm" placeholder="E-mail">
            </div>
          </div>
          <div class="my-2">
              <label for="phone">Address&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="address" class="form-control form-control-sm" placeholder="Address" required>
          </div>
          <div class="row">
              <div class="col-lg">
                  <label for="squareSelect">Supplier Area</label>
                  <div class="form-group d-flex">
                      <select class="form-control form-control-sm input-square" id="areacombobox" name="supp_area">
                        <!-- ajax rendering -->
                      </select>                          
                      <a href="" id="addarea"  data-toggle="modal" data-target="#addareaModal" class="mx-1 btn btn-success btn-link btn-sm fa fa-plus"></a>
                  </div>                           
              </div>
          </div>
          <div class="row"> 
              <div class="col-lg">
                  <label for="avatar">Select Image</label>
                  <input type="file" name="supp_image" class="form-control form-control-sm" id="fileupload">
              </div>
              <div class="col-lg">
                  <div id="dvPreview" class="avatar avatar-xxl">
                  </div>
              </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-sm btn-primary" id="add_supplier_btn">Add Supplier</button>	
        </div>
      </form>
    </div>
  </div>
</div>
<!--Edit Supplier Modal -->
<div class="modal fade bd-example-modal-lg" id="editsupplierModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="progress" style="height: 3px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
      </div>
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <form method="POST" id="edit_supplier_form" enctype="multipart/form-data">
        <div class="modal-body">
          <p class="small text-danger">Field names with * are mendatory</p>
          @csrf
          <input type="hidden" name="supp_id" id="supp_id">
          <input type="hidden" name="supplier_image" id="supplier_image">
          <div class="my-2"> 
            <input type="checkbox" name="alsocust" id="alsocust" /><strong class="mx-2">Also a Customer</strong> 
          </div>
          <div class="row">
            <div class="col-lg">
                <label for="emp_name">Company Name&nbsp;<strong class="text-danger">*</strong></label>
                <input type="text" name="comp_name" id="comp_name" class="form-control form-control-sm" placeholder="Company Name" required>
            </div>
            <div class="col-lg">
              <label for="email">Agency Name</label>
              <input type="text" name="agencyname" id="agencyname" class="form-control form-control-sm" placeholder="Father Name">
            </div>
          </div>
          <div class="my-2">
            <label for="email">Supplier Name&nbsp;<strong class="text-danger">*</strong></label>
            <input type="text" name="supp_name" id="supp_name" class="form-control form-control-sm" placeholder="Supplier name" required>
          </div>
          <div class="row">
            <div class="col-lg">
                <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
                <input type="tel" max="11" pattern="^\d{4}-\d{7}$" name="contact" id="contact" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" placeholder="Contact" required>
            </div>
            <div class="col-lg">
                <label for="phone">E-mail</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="E-mail">
            </div>
          </div>
          <div class="my-2">
            <label for="phone">Address&nbsp;<strong class="text-danger">*</strong></label>
            <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="Address" required>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="squareSelect">Supplier Area</label>
              <div class="form-group d-flex">
                <select class="form-control form-control-sm input-square" id="editareacombobox" name="supp_area">
                  <!-- ajax rendering -->
                </select>                          
                <a href="" id="addtype"  data-toggle="modal" data-target="#addareaModal" class="mx-1 btn btn-success btn-link fa fa-plus"></a>
              </div>                           
            </div>
          </div>
          <div class="row">  
            <div class="col-lg">
              <label for="avatar">Select Image</label>
              <input type="file" name="supp_image" class="form-control form-control-sm" id="fileeditupload">
            </div>
            <div class="col-lg">
              <div id="dveditPreview" class="avatar avatar-xxl">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-sm btn-success" id="edit_supplier_btn">Update Supplier</button>	
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
      $("#addsupplierModal").css({ opacity: 0.3 });
      $('#addsupplierModal').css('z-index', 1039);
      $('#editsupplierModal').css('z-index', 1039);

      $("#editsupplierModal").css({ opacity: 0.3 });
      $('#areamodal-footer').addClass('bg-grey2');
      $('#areamodal-header').addClass('bg-grey2');
      $('#area_modal').removeClass('modal-lg');
      $('#area_modal').addClass('modal-dialog-centered');
      $('input[name=area_name]').focus();
    });
    $('#addareaModal').on('hidden.bs.modal', function () {
      $("#addsupplierModal").css({ opacity: 1 });
      $("#editsupplierModal").css({ opacity: 1 });
      $('#addsupplierModal').css('z-index', 1041);
      $('#editsupplierModal').css('z-index', 1041);

      $('#areamodal-footer').removeClass('bg-grey2');
      $('#areamodal-header').removeClass('bg-grey2');
      $('#area_modal').addClass('modal-lg');
      $('#area_modal').removeClass('modal-dialog-centered');
    });
	  //  //modal open sound
	  //  $(document).on('click','#addsupplier',function(e){
    //   $('#modelopen').trigger('play')
	  //  });
     // fetchsuppliers
        fetchallsuppliers();
        fillareadd();
		function fetchallsuppliers()
		{
			$.ajax({
				url:'{{route('fetchsuppliersdata')}}',
				method:'get',
				success:function(res){
					$('#show_all_suppliers').html(res);
					$('#fetch-supplier').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}
    // //area dropdown fill
    function fillareadd(){
      $.ajax({
				url:'{{route('fetchareadata')}}',
				method:'get',
				success:function(res){
          output='<option value="">--Please select Supplier Area--</option>';
          for(i=0;i<res.length;i++){
            output +='<option value="'+res[i].id+'">'+res[i].area+'</option>';
          }
				 	$('#areacombobox').html(output);
				 	$('#editareacombobox').html(output);
				}
			})
    }

    //edit area dropdown fill
    function fillareaedit(addid){
      $.ajax({
        url:'{{route('fetchareadata')}}',
        method:'get',
        success:function(res){
          output='<option value="">--Please select Supplier Area--</option>';
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

		//edit Supplier
    $(document).on('click','.editsuppliericon',function(e){
    $('#modelopen').trigger('play')
    e.preventDefault();
    let suppid=$(this).attr('id');
        $.ajax({
            method:'get',
            url:'{{route('editsupplier')}}',
            data:{
            id:suppid,
            _token:'{{csrf_token()}}'
            },
            success:function(res){
          $("#comp_name").val(res.company_name);
          $("#agencyname").val(res.agancy_name);
          $("#supp_name").val(res.supp_name);
          $("#address").val(res.address);
          $("#contact").val(res.contact);
          $("#email").val(res.email);
          fillareaedit(res.area);
          if(res.is_customer==="Y")
          {
            $("#alsocust").attr('checked',true);
          }
          else{
            $("#alsocust").attr('checked',false);
          }
          if(res.supp_image){
            $("#dveditPreview").html(`<img src="storage/images/cust_supplier_images/${res.supp_image}" 
            class="avatar-img rounded"/>`);
          }
          else{
            $("#dveditPreview").html(`<img src="{{asset('user.webp')}}" 
            class="avatar-img rounded"/>`);
          }
          $('#supp_id').val(res.id);
          $('#supplier_image').val(res.supp_image);
        
            
            }
        });
    })
 	  //delete employee
	  $(document).on('click','.deletesuppliericon',function(e){
      e.preventDefault();
      $('#warningsound').trigger('play');
       let suppid=$(this).attr('id');
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
             url:'{{route('supplierdelete')}}',
             data:{
               id:suppid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Supplier Record has been deleted successfully.',
                 'success'
                 )
               fetchallsuppliers();
              }
            }
          })
        }
      })
    })

	  //update customers data
	  $('#edit_supplier_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_supplier_btn').text('Updating...');
	   $("#edit_supplier_btn").prop('disabled', true);
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
         url:'{{route('updatesupplier')}}',
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
              'Supplier record has been Updated successfully',
              'success'
            )
            fetchallsuppliers();
            $('#edit_supplier_btn').text('Update Supplier'); 
            $("#edit_supplier_btn").prop('disabled', false);
            $('#edit_supplier_form')[0].reset();
            $('#dveditPreview').html("");
            $('#editsupplierModal').modal('hide');
          }      
        }
      })
    })

 		//add Suppliers
		$('#add_supplier_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_supplier_btn').text('Adding...');
		$("#add_supplier_btn").prop('disabled', true);
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
			url:'{{route('addsupplier')}}',
			data:cd,
			cache:false,
			processData:false,
			contentType:false,
			beforeSend: function(){
			$(".progress-bar").width('0%');
			},
			success:function(res){
      console.log(res)
      $(".progress-bar").width('0%');
      if(res.status===200){
        $('#successsound').trigger('play')
        swal(
        'Added!',
        'Supplier record has been added successfully',
        'success'
        )
        fetchallsuppliers()
      $('#add_supplier_btn').text('Add Supplier');
      $("#add_supplier_btn").prop('disabled', false);
      $('#add_supplier_form')[0].reset();
      $('#dvPreview').html("");
      $('#addsupplierModal').modal('hide');
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


// //add area
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



//     //add Type
// 		$('#add_type_form').submit(function(e){
// 		e.preventDefault();
// 		const cd=new FormData(this);
// 		$('#add_Type_btn').text('Adding...');
// 		$("#add_Type_btn").prop('disabled', true);
// 		$.ajax({
// 				xhr: function() 
// 				{
// 					var xhr = new window.XMLHttpRequest();
// 					xhr.upload.addEventListener("progress", function(evt) {
// 						if (evt.lengthComputable) {
// 							var percentComplete = ((evt.loaded / evt.total) * 100);
// 							$(".progress-bar").width(percentComplete + '%');
// 						}
// 					}, false);
// 					return xhr;
// 				},
// 			method:'POST',
// 			url:'{{route('addtype')}}',
// 			data:cd,
// 			cache:false,
// 			processData:false,
// 			contentType:false,
// 			beforeSend: function(){
// 			$(".progress-bar").width('0%');
// 			},
// 			success:function(res){
// 					$(".progress-bar").width('0%');
// 					if(res.status===200){
// 						$('#successsound').trigger('play')
// 						swal(
// 						'Added!',
// 						'Area has been added successfully',
// 						'success'
// 						)
// 						filltypeadd();
// 					$('#add_type_btn').text('Add Type');
// 					$("#add_type_btn").prop('disabled', false);
// 					$('#add_type_form')[0].reset();
// 					$('#addtypeModal').modal('hide');
// 					}
					
// 					}

// 		})
// 		})



</script>
@endsection



