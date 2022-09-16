@extends('layouts.master')
@section('content')
<div class="content">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Expenses</h4>
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
          <a href="#">Expense</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Add New Expense</h4>
              <button class="btn btn-primary btn-round ml-auto" id="addexp" data-toggle="modal" data-target="#addExpenseModal">
                <i class="fa fa-plus"></i>
                New Expense
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" id="show_all_expenses">	
              <h1 class="text-center text-secondary my-5">Loading...</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Add Expense -->
<div class="modal fade bd-example-modal-lg" id="addExpenseModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="add_expense_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fname">Expense Name</label>
                            <select name="cat_id" id="" class="form-control" required>
                                <option value="">Please Select</option>
                                @foreach($category as $list)
                                <option value="{{$list->id}}">{{$list->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Expense Amount</label>
                            <input type="text" class="form-control" required name="exp_amount">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Added By</label>
                            <input type="text" class="form-control" required name="exp_addedby">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Expense Date</label>
                            <input type="date" class="form-control" required value="{{$mytime}}" name="exp_date">
                        </div>
                        <div class="col-md-12">
                        <label for="fname">Expense Description</label>
                        <textarea name="exp_desc" id="" cols="3" class="form-control" required rows="3"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add_expense_btn">Add Expense</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- edit Expense -->
<div class="modal fade bd-example-modal-lg" id="editExpensesModal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" id="cat_modal" role="document">
        <div class="modal-content">
            <div class="progress" style="height: 3px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="78"
                    aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title=""
                    data-original-title="78%"></div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">Make sure you fill them all</p>
                <form method="POST" id="edit_expense_form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="exp_id" id="exp_id">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="fname">Expense Name</label>
                            <select name="cat_id" id="cat_id" class="form-control" required>
                                <option value="">Please Select</option>
                                @foreach($category as $list)
                                <option value="{{$list->id}}">{{$list->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Expense Amount</label>
                            <input type="text" class="form-control" id="exp_amount" required name="exp_amount">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Added By</label>
                            <input type="text" class="form-control" id="exp_addedby" required name="exp_addedby">
                        </div>
                        <div class="col-md-6">
                            <label for="fname">Expense Date</label>
                            <input type="date" class="form-control" id="exp_date" required value="{{$mytime}}" name="exp_date">
                        </div>
                        <div class="col-md-12">
                        <label for="fname">Expense Description</label>
                        <textarea name="exp_desc" id="exp_desc" cols="3" class="form-control" required rows="3"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="edit_expense_btn">Update Expense</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('Scripts')
<script>
//modal open sound
$(document).on('click', '#addexp', function(e) {
    $('#modelopen').trigger('play')
});
// fetchexpenses
fetchallexpenses();

function fetchallexpenses() {
    $.ajax({
        url: '{{route('fetchexpenses')}}',
        method: 'get',
        success: function(res) {
            $('#show_all_expenses').html(res);
            $('#add-row').DataTable({
                "pageLength": 5,
            });
        }
    })
}

//editcategory
$(document).on('click', '.editexpenseicon', function(e) {
    $('#modelopen').trigger('play')
    e.preventDefault();
    let expid = $(this).attr('id');
    $.ajax({
        method: 'get',
        url: '{{route('editexpenses')}}',
        data: {
            id: expid,
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
            $('#exp_id').val(res.id);
            $('#cat_id').val(res.cat_id);
            $('#exp_amount').val(res.exp_amount);
            $('#exp_date').val(res.exp_date);
            $('#exp_desc').val(res.exp_desc);
            $('#exp_addedby').val(res.exp_addedby);

        }
    });
})
//delete Expense
$(document).on('click', '.deleteexpenseicon', function(e) {
    e.preventDefault();
    $('#warningsound').trigger('play');
    let expid = $(this).attr('id');
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
                url: '{{route('expdelete')}}',
                data: {
                    id: expid,
                    _token: '{{csrf_token()}}'
                },
                success: function(res) {
                    if (res.status === 200) {
                        $('#successsound').trigger('play')
                        swal(
                            'Deleted!',
                            'Expense has been deleted successfully.',
                            'success'
                        )
                        fetchallexpenses();
                    }
                }

            })
        }
    })
})

//update Expense data
$('#edit_expense_form').submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $('#edit_expense_btn').text('Updating...');
    $("#edit_expense_btn").prop('disabled', true);
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
        url: '{{route('updateexpenses')}}',
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
                    'Expense has been Updated successfully',
                    'success'
                )
                fetchallexpenses();
                $('#edit_expense_btn').text('Update Expense');
                $("#edit_expense_btn").prop('disabled', false);
                $('#edit_expense_form')[0].reset();
                $('#editExpensesModal').modal('hide');
            }


        }
    })
})

//add expense
$('#add_expense_form').submit(function(e) {
    e.preventDefault();
    const cd = new FormData(this);
    $('#add_expense_btn').text('Adding...');
    $("#add_expense_btn").prop('disabled', true);
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
        url: '{{route('addexpense')}}',
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
                    'Expense has been added successfully',
                    'success'
                )
                fetchallexpenses();
                $('#add_expense_btn').text('Add Expense');
                $("#add_expense_btn").prop('disabled', false);
                $('#add_expense_form')[0].reset();
                $('#addExpenseModal').modal('hide');
            }

        }

    })
})
</script>
@endsection