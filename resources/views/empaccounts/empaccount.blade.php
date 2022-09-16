@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Employee Account</h4>
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
                    <a href="#">Employee Account</a>
                </li>
                
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                            <div class="row align-items-center">
                                <div class="form-group form-inline mt-2 col-md-4">
                                    <h4 for="inlineinput" class="card-title mr-3">Employee Account</h4>
                                </div>   
                                <div class="col-md-8 mt-2">
                                <button type="button" class="btn btn-primary btn-sm float-right mx-2" data-toggle="modal" data-target="#empaddpayment">
                                    Add Payment
                                </button>
                                <button type="button" class="btn btn-primary btn-sm float-right mx-2" data-toggle="modal" data-target="#empwithdraw">
                                    WithDraw Payment
                                </button>
                                </div> 
                            </div>
                    </div>
                    <div class="card-body">   
                    <div class="row">
                                <div class="col-md-3">
                                    <b> From : </b><input type="date" id="from" style="width: 80%;" name="d1"
                                        class="tcal form-control form-control-sm" value="{{$mytime}}" />
                                </div>
                                <div class="col-md-3">
                                    <b> To:</b> <input type="date" id="to" style="width: 80%;" name="d2"
                                        class="tcal form-control form-control-sm" value="{{$mytime1}}" />
                                </div>
                                <div class="col-md-3">
                                    <b>Employee</b>
                                    <select name="" id="employee" class="tcal form-control search-dropdown">
                                        <option value="">Select Employee</option>
                                        @foreach($employee as $list)
                                        <option value="{{$list->id}}">{{$list->emp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button class="btn btn-info btn-sm" type="submit" id="filter"><i
                                            class="fa fa-search" aria-hidden="true"></i></button>
                                    <a href="{{route('empaccount')}}" class="btn btn-warning btn-sm"><i
                                            class="fas fa-redo-alt"></i></a>
                                </div>
                            </div>
                        <hr>
                        <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
                                <div class="table-responsive" id="empaccount">	
                                     <h1 class="text-center text-secondary my-5">Select Employee to load the account details.</h1>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Payment -->
<div class="modal fade" id="empaddpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="frm_emp_payment">
        @csrf
        <div class="mb-2">
            <label for="customer">Employee &nbsp;<strong class="text-danger">*</strong></label><br>
            <select name="emp_id" id="" required class="form-control form-control-sm mb-2 search-dropdown" style="width:100%">
                <option value="">Please Select Employee</option>
                @foreach($employee as $list)
                <option value="{{$list->id}}">{{$list->emp_name}}</option>
                @endforeach
            </select>
        </div>
        <label for="amount">Amount &nbsp;<strong class="text-danger">*</strong></label>
        <input type="number" class="form-control form-control-sm mb-2" name="emp_earning" required id="amount">
        <label for="date">Date &nbsp;<strong class="text-danger">*</strong></label>
        <input type="date" class="form-control form-control-sm mb-2" name="emp_acc_date" required value="{{$mytime}}" id="">
        <label for="amount">Added By &nbsp;<strong class="text-danger">*</strong></label>
        <input type="text" class="form-control form-control-sm mb-2" name="addedby" required>
        <label for="amount">Note &nbsp;</label>
        <textarea name="note" id="" cols="2" rows="2" class="form-control"></textarea>

        <button class="btn btn-xs btn-primary pull-right mt-2" type="submit" id="addbtn">Add Payment</button>
    </form>  
      </div>

    </div>
  </div>
</div>
<!-- Withdraw Payment -->
<div class="modal fade" id="empwithdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Withdraw Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="frm_emp_withdraw">
        @csrf
        <div class="mb-2">
            <label for="customer">Employee &nbsp;<strong class="text-danger">*</strong></label><br>
            <select name="emp_id" id="" required class="form-control form-control-sm mb-2 search-dropdown" style="width:100%">
                <option value="">Please Select Employee</option>
                @foreach($employee as $list)
                <option value="{{$list->id}}">{{$list->emp_name}}</option>
                @endforeach
            </select>
        </div>
        <label for="amount">Amount &nbsp;<strong class="text-danger">*</strong></label>
        <input type="number" class="form-control form-control-sm mb-2" name="emp_withdraw_amount" required id="amount">
        <label for="date">Date &nbsp;<strong class="text-danger">*</strong></label>
        <input type="date" class="form-control form-control-sm mb-2" name="emp_acc_date" required value="{{$mytime}}" id="">
        <label for="amount">Added By &nbsp;<strong class="text-danger">*</strong></label>
        <input type="text" class="form-control form-control-sm mb-2" name="addedby" required >
        <label for="amount">Note &nbsp;</label>
        <textarea name="note" id="" cols="2" rows="2" class="form-control"></textarea>

        <button class="btn btn-xs btn-primary pull-right mt-2" type="submit" id="add_btn">Add payment</button>
    </form>  
      </div>

    </div>
  </div>
</div>
@endsection
@section('Scripts')
<script>
            
   

// fetchusers
fetchemppayment();
function fetchemppayment() {
    $.ajax({
        url: "{{route('fetchemppayment')}}",
        method: 'get',
        data: {
            from: $('#from').val(),
            to: $('#to').val(),
            employee: $('#employee').val(),
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
            $('#empaccount').html(res);
            $('#add-row').DataTable({
                "pageLength": 10,
            });
        }
    })
}
$('#filter').on('click', function(e) {
    e.preventDefault();
    fetchemppayment();
});

    //add Payment
$('#frm_emp_payment').submit(function(e) {
    e.preventDefault();
    const cd = new FormData(this);
    $('#addbtn').text('Adding...');
    $("#addbtn").prop('disabled', true);
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
        url: '{{route('addpayment')}}',
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
                    'Payment has been added successfully',
                    'success'
                )
                /* fetchallusers(); */
                $('#addbtn').text('Add Payment');
                $("#addbtn").prop('disabled', false);
                $('#frm_emp_payment')[0].reset();
                $('#empaddpayment').modal('hide');
            

        }

    })
})
    //withdraw Payment
    $('#frm_emp_withdraw').submit(function(e) {
    e.preventDefault();
    const cd = new FormData(this);
    $('#add_btn').text('Adding...');
    $("#add_btn").prop('disabled', true);
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
        url: '{{route('withdrawpayment')}}',
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
                    'Withdraw has been successfully',
                    'success'
                )
                /* fetchallusers(); */
                $('#add_btn').text('Add Payment');
                $("#add_btn").prop('disabled', false);
                $('#frm_emp_withdraw')[0].reset();
                $('#empwithdraw').modal('hide');
            

        }

    })
})
</script>
@endsection



