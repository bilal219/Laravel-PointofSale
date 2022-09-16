@extends('layouts.master')
@section('content')

			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Employees</h4>
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
								<a href="#">Employees</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add New Employee</h4>
										<button class="btn btn-primary btn-round ml-auto" id="addemployee" data-toggle="modal" data-target="#addemployeeModal">
											<i class="fa fa-plus"></i>
											New Employee
										</button>
									</div>
								</div>
								<div class="card-body">
									
									<div class="table-responsive" id="show_all_employees">	
									  <h1 class="text-center text-secondary my-5">Loading...</h1>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!--Add Employee Modal -->
<div class="modal fade bd-example-modal-lg" id="addemployeeModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="progress" style="height: 3px;">
				<div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
			</div>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Employee</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
      <p class="small text-danger">Field names with * are mendatory</p>
				<form method="POST" id="add_employee_form" enctype="multipart/form-data">
				@csrf
          <div class="row">
            <div class="col-lg">
              <label for="emp_name">Employee Name&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="emp_name" class="form-control form-control-sm" placeholder="Employee Name" required>
            </div>
            <div class="col-lg">
              <label for="email">E-mail</label>
              <input type="email" name="email" class="form-control form-control-sm" placeholder="E-mail">
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
              <input type="tel" name="contact" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" placeholder="Contact" required>
            </div>
            <div class="col-lg">
              <label for="phone">CNIC&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="cnic" max="13" pattern="^\d{5}-\d{7}-\d{1}$" data-inputmask="'mask': '99999-9999999-9'"  placeholder="XXXXX-XXXXXXX-X" class="form-control form-control-sm" placeholder="CNIC" required>
            </div>
          </div>
          <div class="my-2">
            <label for="phone">Address&nbsp;<strong class="text-danger">*</strong></label>
            <input type="text" name="address" class="form-control form-control-sm" placeholder="Address" required>
          </div>
          <div class="form-check">
            <label>Employee Type&nbsp;<strong class="text-danger">*</strong></label><br>
            <div class="row"> 
              <div>    
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="emp_type" id="worker" value="Worker" checked>
                  <span class="form-radio-sign">Worker</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" id="other" value="other" name="emp_type">
                  <span class="form-radio-sign">Other</span>
                </label>
              </div>
              <div class="col-lg">
                <input class="form-control form-control-sm input-border-bottom" type="text" id="checkinput" name="employeetype" required />
              </div>
            </div>
          </div>
          <div class="row"> 
            <div class="col-lg">
             <label for="avatar">Select Image</label>
             <input type="file" name="employeeimg" class="form-control form-control-sm" id="fileupload">
            </div>
            <div class="col-lg">
              <div id="dvPreview" class="avatar avatar-xxl">
              </div>
            </div>  
          </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-sm btn-primary" id="add_employee_btn">Add Employee</button>	
			</div>
			</form>
		</div>
	</div>
</div>

<!--Edit Employee Modal -->
<div class="modal fade bd-example-modal-lg" id="editemployeeModal" tabindex="-1" role="dialog"  data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="" data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <p class="small text-danger">Field names with * are mendatory</p>
                <form method="POST" id="edit_employee_form">
                @csrf
                <input type="hidden" name="emp_id" id="emp_id">
                <input type="hidden" name="emp_image" id="emp_image">
                <div class="row">
            <div class="col-lg">
              <label for="emp_name">Employee Name&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="emp_name" id="emp_name" class="form-control form-control-sm" placeholder="Employee Name" required>
            </div>
            <div class="col-lg">
              <label for="email">E-mail</label>
              <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="E-mail">
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="contact">Contact&nbsp;<strong class="text-danger">*</strong></label>
              <input type="tel" name="contact" max="11" pattern="^\d{4}-\d{7}$" id="contact" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" placeholder="Contact" required>
            </div>
            <div class="col-lg">
              <label for="phone">CNIC&nbsp;<strong class="text-danger">*</strong></label>
              <input type="text" name="cnic" max="13" pattern="^\d{5}-\d{7}-\d{1}$" id="cnic" data-inputmask="'mask': '99999-9999999-9'"  placeholder="XXXXX-XXXXXXX-X" class="form-control form-control-sm" placeholder="CNIC" required>
            </div>
          </div>
          <div class="my-2">
            <label for="phone">Address&nbsp;<strong class="text-danger">*</strong></label>
            <input type="text" name="address" id="address" class="form-control form-control-sm" placeholder="Address" required>
          </div>
          <div class="form-check">
            <label>Employee Type&nbsp;<strong class="text-danger">*</strong></label><br>
            <div class="row"> 
              <div>    
                <label class="form-radio-label">
                    <input class="form-radio-input" type="radio" name="emp_type" id="workeredit" value="Worker" checked>
                    <span class="form-radio-sign">Worker</span>
                </label>
                <label class="form-radio-label ml-3">
                    <input class="form-radio-input" type="radio" id="otheredit" value="other" name="emp_type">
                    <span class="form-radio-sign">Other</span>
                </label>
              </div>
              <div class="col-lg">
                <input class="form-control form-control-sm input-border-bottom" type="text" id="checkinputedit" name="employeetype" required />
              </div>
            </div>
          </div>
         <div class="row"> 
           <div class="col-lg">
             <label for="avatar">Select Image</label>
             <input type="file" name="employeeimg" class="form-control form-control-sm" id="fileeditupload">
           </div>
           <div class="col-lg">
              <div id="dveditPreview" class="avatar avatar-xxl">
              </div>
           </div>  
         </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-success" id="edit_employee_btn">Update Employee</button>	
            </div>
            </form>
        </div>
    </div>
</div>	
@endsection
@section('Scripts')
   <script>
     //add disable enable
   $(document).ready(function() {
    $("#checkinput").prop('disabled', true);
      $("input[type='radio']").change(function() {
          if ($(this).val() == "other") {
            $("#checkinput").prop('disabled', false);
          } else {
            $("#checkinput").prop('disabled', true);
          }
      });
    });
    //edit disable enable
    $(document).ready(function() {
    $("#checkinputedit").prop('disabled', true);
      $("input[type='radio']").change(function() {
          if ($(this).val() == "other") {
            $("#checkinputedit").prop('disabled', false);
          } else {
            $("#checkinputedit").prop('disabled', true);
            $("#checkinputedit").val('');
          }
      });
    });

	   //modal open sound
	   $(document).on('click','#addemployee',function(e){
      $('#modelopen').trigger('play')
	   });
     // fetchemployees
       fetchallemployees();
		function fetchallemployees()
		{
			$.ajax({
				url:'{{route('fetchemployeedata')}}',
				method:'get',
				success:function(res){
					$('#show_all_employees').html(res);
					$('#fetch-employee').DataTable({
				       "pageLength": 5,
			        });
				}
			})
		}

		//editemployees
		$(document).on('click','.editemployeeicon',function(e){
      $('#modelopen').trigger('play')
       e.preventDefault();
       let empid=$(this).attr('id');
       $.ajax({
         method:'get',
         url:'{{route('editemployee')}}',
         data:{
           id:empid,
           _token:'{{csrf_token()}}'
         },
         success:function(res){
         $("#emp_name").val(res.emp_name);
          $("#address").val(res.address);
          $("#contact").val(res.contact);
          $("#cnic").val(res.cnic);
          $("#email").val(res.email);
          $("#dveditPreview").html('<img src="/user.webp" class="avatar-img rounded"/>');
          if(res.emp_image)
          {
            $("#dveditPreview").html(`<img src="storage/images/employee_images/${res.emp_image}" 
            class="avatar-img rounded"/>`);
          }
          $('#emp_id').val(res.id);
          if(res.emp_type==="Worker")
          {
            $('#checkinputedit').val("");
            $("#checkinputedit").prop('disabled', true);
            $("#workeredit").prop("checked", true)
          }
          else{
            $('#checkinputedit').val(res.emp_type);
            $("#checkinputedit").prop('disabled', false);
            $("#otheredit").prop("checked", true)
          }
          $('#emp_image').val(res.emp_image);
          
         }
       });
     })
	  //delete employee
	  $(document).on('click','.deleteemployeeicon',function(e){
       e.preventDefault();
     $('#warningsound').trigger('play');
       let catid=$(this).attr('id');
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
             url:'{{route('employeedelete')}}',
             data:{
               id:catid,
               _token:'{{csrf_token()}}'
             },
             success:function(res)
             {
               if(res.status===200)
               {
                 $('#successsound').trigger('play')
                 swal(
                 'Deleted!',
                 'Employee Record has been deleted successfully.',
                 'success'
                 )
               fetchallemployees();
               }
             }

           })
          }
        })
     })

	  //update employee data
	  $('#edit_employee_form').submit(function(e){
       e.preventDefault();
       const fd=new FormData(this);
       $('#edit_employee_btn').text('Updating...');
	   $("#edit_employee_btn").prop('disabled', true);
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
         url:'{{route('updateemployee')}}',
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
                  'Employee record has been Updated successfully',
                  'success'
                )
                fetchallemployees();
                $('#edit_employee_btn').text('Update Employee'); 
                $("#edit_employee_btn").prop('disabled', false);
                $('#edit_employee_form')[0].reset();
                $('#dveditPreview').html("");
                $('#editemployeeModal').modal('hide');
          }
                  
              
         }
       })
     })

		//add employees
		$('#add_employee_form').submit(function(e){
		e.preventDefault();
		const cd=new FormData(this);
		$('#add_employee_btn').text('Adding...');
		$("#add_employee_btn").prop('disabled', true);
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
			url:'{{route('addemployee')}}',
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
          'Employee has been added successfully',
          'success'
          )
          fetchallemployees();
          $('#add_employee_btn').text('Add Employee');
          $("#add_employee_btn").prop('disabled', false);
          $('#add_employee_form')[0].reset();
          $('#dvPreview').html("");
          $('#addemployeeModal').modal('hide');
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
</script>
@endsection



