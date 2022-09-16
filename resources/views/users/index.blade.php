@extends('layouts.master')
@section('content')

			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Users</h4>
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
								<a href="#">Users</a>
							</li>
							
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Add New User</h4>
										<button class="btn btn-primary btn-round ml-auto" id="adduser" data-toggle="modal" data-target="#adduserModal">
											<i class="fa fa-plus"></i>
											New User
										</button>
									</div>
								</div>
								<div class="card-body">
									
									<div class="table-responsive" id="show_all_users">	
									  <h1 class="text-center text-secondary my-5">Loading...</h1>
								    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!--Add User Modal -->
<div class="modal fade bd-example-modal-lg" id="adduserModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_user_form">
                    @csrf
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="fname">User Name</label>
                            <input type="text" class="form-control" required name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Contact#</label>
                            <input type="tel" name="contact" data-inputmask="'mask': '0399-9999999'" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">CNIC#</label>
                            <input type="text" name="cnic" data-inputmask="'mask': '99999-9999999-9'" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Confirm Password</label>
                            <input type="password" id="confirm_password" class="form-control" required>
                        </div>
						<div class="col-md-6">
						<label for="fname">Role</label>
							<select name="role" class="form-control">
								<option value="">Select Role</option>
								<option value="Admin">Admin</option>
								<option value="Cashier">Cashier</option>
							</select>
						</div>
                        <div class="col-md-6">
                        <label for="fname">User Picture</label>
                            <input type="file" name="pic" class="form-control" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_user_btn">Add User</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Edit User Modal -->
<div class="modal fade bd-example-modal-lg" id="edituserModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="edit_user_form">
                    @csrf
					@method('PUT')
					<input type="hidden" name="user_id" id="user_id" >
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="fname">User Name</label>
                            <input type="text" id="name" class="form-control" required name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Contact#</label>
                            <input type="tel" id="contact" name="contact" data-inputmask="'mask': '0399-9999999'" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">CNIC#</label>
                            <input type="text" name="cnic" id="cnic" data-inputmask="'mask': '99999-9999999-9'" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
						<div class="col-md-6">
						<label for="fname">Role</label>
							<select name="role" class="form-control" id="role">
								<option value="">Select Role</option>
								<option value="Admin">Admin</option>
								<option value="Cashier">Cashier</option>
							</select>
						</div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="edit_user_btn">Update User</button>
            </div>
            </form>
        </div>
    </div>
</div>
	
		
@endsection
@section('Scripts')
<script>
   var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
<script>
//modal open sound
$(document).on('click', '#adduser', function(e) {
    $('#modelopen').trigger('play')
});
// fetchusers
fetchallusers();

function fetchallusers() {
    $.ajax({
        url: '{{route('fetchusers')}}',
        method: 'get',
        success: function(res) {
            $('#show_all_users').html(res);
            $('#add-row').DataTable({
                "pageLength": 5,
            });
        }
    })
}

//edituser
$(document).on('click', '.editusericon', function(e) {
    $('#modelopen').trigger('play')
    e.preventDefault();
    let userid = $(this).attr('id');
    $.ajax({
        method: 'get',
        url: '{{route('editusers')}}',
        data: {
            id: userid,
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
            $('#user_id').val(res.id);
            $('#name').val(res.name);
            $('#contact').val(res.contact);
            $('#cnic').val(res.cnic);
            $('#email').val(res.email);
            $('#role').val(res.role);

        }
    });
})
//delete User
$(document).on('click', '.deleteusericon', function(e) {
    e.preventDefault();
    $('#warningsound').trigger('play');
    let userid = $(this).attr('id');
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
                url: '{{route('userdelete')}}',
                data: {
                    id: userid,
                    _token: '{{csrf_token()}}'
                },
                success: function(res) {
                    if (res.status === 200) {
                        $('#successsound').trigger('play')
                        swal(
                            'Deleted!',
                            'User has been deleted successfully.',
                            'success'
                        )
                        fetchallusers();
                    }
                }

            })
        }
    })
})

//update User data
$('#edit_user_form').submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $('#edit_user_btn').text('Updating...');
    $("#edit_user_btn").prop('disabled', true);
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
        url: '{{route('updateusers')}}',
        data: fd,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".progress-bar").width('0%');
        },
        success: function(res) {
            $(".progress-bar").width('0%');
            if (res.status === 200) {
                $('#successsound').trigger('play')
                swal(
                    'Updated!',
                    'User has been Updated successfully',
                    'success'
                )
                fetchallusers();
                $('#edit_user_btn').text('Update User');
                $("#edit_user_btn").prop('disabled', false);
                $('#edit_user_form')[0].reset();
                $('#edituserModal').modal('hide');
            }


        }
    })
})

//add user
$('#add_user_form').submit(function(e) {
    e.preventDefault();
    const cd = new FormData(this);
    $('#add_user_btn').text('Adding...');
    $("#add_user_btn").prop('disabled', true);
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
        url: '{{route('adduser')}}',
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
                    'User has been added successfully',
                    'success'
                )
                fetchallusers();
                $('#add_user_btn').text('Add User');
                $("#add_user_btn").prop('disabled', false);
                $('#add_user_form')[0].reset();
                $('#adduserModal').modal('hide');
            

        }

    })
})
</script>
@endsection



