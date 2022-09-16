@extends('layouts.master')
@section('content')
<div class="content">
  <div class="page-inner">
        <div class="page-header">
        <h4 class="page-title">Bussiness Detail</h4>
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
            <a href="#">Bussiness Details</a>
            </li>
        </ul>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    @if($show)
                        <h4 class="card-title">Add Bussiness Details</h4>
                        <button class="btn btn-primary btn-round ml-auto" id="addcomp" data-toggle="modal" data-target="#addcompModal">
                        <i class="fa fa-plus"></i>
                        New Bussiness Detals
                        </button>
                    </div>
                    @else
                    <h4 class="card-title">Bussiness Details</h4>
                    @endif
            </div>
            <div class="card-body">
                <div class="table-responsive" id="show_all_comp">	
                <h1 class="text-center text-secondary my-5">Loading...</h1>
                </div>
            </div>
            </div>
        </div>
        </div>
  </div>
</div>
<!-- Add Company -->
<div class="modal fade bd-example-modal-lg" id="addcompModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="comp_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%">
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="add_comp_form">
                @csrf
                <div class="modal-body">
                    <p class="small text-danger">Field names with * are mendatory</p>
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Name&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control form-control-sm" required name="comp_name">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Urdu Name&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control form-control-sm" required name="comp_urdu_name">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Address&nbsp;<strong class="text-danger">*</strong></label>
                            <textarea name="comp_address" class="form-control form-control-sm" required>
                            </textarea>
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Urdu Address&nbsp;<strong class="text-danger">*</strong></label>
                            <textarea name="comp_urdu_address" class="form-control form-control-sm" required>
                            </textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 1&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" required name="comp_cont1">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 2</label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" name="comp_con2">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 3</label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" name="comp_con3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg mb-2">
                            <label for="fname">Business Email</label>
                            <input type="email" class="form-control form-control-sm" name="comp_email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="add_comp_btn">Add Company</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit Company -->
<div class="modal fade bd-example-modal-lg" id="editcompModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="comp_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%">
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="edit_comp_form">
            @csrf
            <div class="modal-body">
                <p class="small text-danger">Field names with * are mendatory</p>
                    <input type="hidden" name="comp_id" id="comp_id">
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Name&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control form-control-sm" id="comp_name" required name="comp_name">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Urdu Name&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control form-control-sm" id="comp_urdu_name" required name="comp_urdu_name">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Address&nbsp;<strong class="text-danger">*</strong></label>
                            <textarea name="comp_address" class="form-control form-control-sm" id="comp_address" required>
                            </textarea>
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Urdu Address&nbsp;<strong class="text-danger">*</strong></label>
                            <textarea name="comp_urdu_address" id="comp_urdu_address" class="form-control form-control-sm" required>
                            </textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 1&nbsp;<strong class="text-danger">*</strong></label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" required name="comp_cont1" id="comp_cont1">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 2</label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" name="comp_cont2" id="comp_cont2">
                        </div>
                        <div class="col-lg mb-2">
                            <label for="fname">Contact 3</label>
                            <input type="tel" max="11" pattern="^\d{4}-\d{7}$" data-inputmask="'mask': '0399-9999999'" class="form-control form-control-sm" name="comp_cont3" id="comp_cont3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg mb-2">
                            <label for="fname">Business Email</label>
                            <input type="email" class="form-control form-control-sm" name="comp_email" id="comp_email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit_comp_btn">Update Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('Scripts')
<script>
//modal open sound
$(document).on('click', '#addcomp', function(e) {
    $('#modelopen').trigger('play')
});
// fetchcompanies
fetchallcomp();

function fetchallcomp() {
    $.ajax({
        url: '{{route('fetchcomp')}}',
        method: 'get',
        success: function(res) {
            $('#show_all_comp').html(res);
            $('#add-row').DataTable({
                "pageLength": 5,
            });
        }
    })
}

//editcomp
$(document).on('click', '.editcompicon', function(e) {
    e.preventDefault();
    let compid = $(this).attr('id');
    $.ajax({
        method: 'get',
        url: '{{route('editcomp')}}',
        data: {
            id: compid,
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
            $('#comp_id').val(res.id);
            $('#comp_name').val(res.Bus_Name);
            $('#comp_urdu_name').val(res.Bus_Name_Ur);
            $('#comp_email').val(res.Bus_email);
            $('#comp_cont1').val(res.Bus_Contact1);
            $('#comp_cont2').val(res.Bus_Contact2);
            $('#comp_cont3').val(res.Bus_Contact3);
            $('#comp_address').val(res.Bus_Address);
            $('#comp_urdu_address').val(res.Bus_Address_Ur);
        }
    });
})
//delete Company
$(document).on('click', '.deletecompicon', function(e) {
    e.preventDefault();
    $('#warningsound').trigger('play');
    let compid = $(this).attr('id');
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
                url: '{{route('compdelete')}}',
                data: {
                    id: compid,
                    _token: '{{csrf_token()}}'
                },
                success: function(res) {
                    if (res.status === 200) {
                        $('#successsound').trigger('play')
                        swal(
                            'Deleted!',
                            'Company has been deleted successfully.',
                            'success'
                        )
                        fetchallcomp();
                    }
                }

            })
        }
    })
})

//update Company data
$('#edit_comp_form').submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $('#edit_comp_btn').text('Updating...');
    $("#edit_comp_btn").prop('disabled', true);
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
        url: '{{route('updatecomp')}}',
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
                    'Company has been Updated successfully',
                    'success'
                )
                fetchallcomp();
                $('#edit_comp_btn').text('Update Expense');
                $("#edit_comp_btn").prop('disabled', false);
                $('#edit_comp_form')[0].reset();
                $('#editcompModal').modal('hide');
                window.location.href="dashboard"
            }


        }
    })
})

//add company
$('#add_comp_form').submit(function(e) {
    e.preventDefault();
    const cd = new FormData(this);
    $('#add_comp_btn').text('Adding...');
    $("#add_comp_btn").prop('disabled', true);
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
        url: '{{route('addcomp')}}',
        data: cd,
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
                    'Added!',
                    'Bussiness details has been added successfully',
                    'success'
                )
                fetchallcomp();
                $('#add_comp_btn').text('Add Company');
                $("#add_comp_btn").prop('disabled', false);
                $('#add_comp_form')[0].reset();
                $('#addcompModal').modal('hide');
                window.location.href="dashboard"

            }

        }

    })
})
</script>
@endsection