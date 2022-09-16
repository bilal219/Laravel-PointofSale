@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Supplier Cheques Report</h4>
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
                    <a href="#">Supplier Cheques</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <div class="container1">
                <center>
                    <h1><b> Technors POS </b></h1>
                    <p>Mumtaz Market Gujranwala</p>
                    <h3><u> CHEQUE LIST</u></h3>
                </center>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    <div class="card card-body card-outline">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <b> From : </b><input type="date" id="from" style="width: 80%;" name="d1"
                                        class="tcal form-control" value="{{$mytime}}" />
                                </div>
                                <div class="col-md-3">
                                    <b> To:</b> <input type="date" id="to" style="width: 80%;" name="d2"
                                        class="tcal form-control" value="{{$mytime1}}" />
                                </div>
                                <div class="col-md-3">
                                    <b>Status</b>
                                    <select name="" required id="status" class="tcal form-control select2bs4">
                                        <option value="">Select Status</option>
                                        <option value="Due">Due</option>
                                        <option value="Cleared">Cleared</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <b>Amount Type</b>
                                    <select name="" required id="type" class="tcal form-control select2bs4">
                                        <option value="">Select Amount Type</option>
                                        <option value="received_in_company">Received in Company</option>
                                        <option value="paid_by_company">Paid By Company</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button class="btn btn-info btn-sm" type="submit" id="filter"><i
                                            class="fa fa-search" aria-hidden="true"></i></button>
                                    <a href="{{route('customercheques')}}" class="btn btn-warning btn-sm"><i
                                            class="fas fa-redo-alt"></i></a>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive" id="show_all_fetchcheques">
                                <h1 class="text-center text-secondary my-5">Loading...</h1>
                            </div>

                            <center>
                                <button class="btn btn-success btn-sm" id="print"><i class="fa fa-download"
                                        aria-hidden="true"></i>
                                    Download</button>
                            </center>
                        </div>
                    </div><!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div>
    </div>
</div>


@endsection
@section('Scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"
    integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {


    $("#print").click(function() {
        $(".container1").printThis({

        });
    });
});
</script>
<script>
fetchsuppliercheques();
function fetchsuppliercheques() {
    $.ajax({
        url: "{{route('fetchsuppliercheques')}}",
        method: 'get',
        data: {
            from: $('#from').val(),
            to: $('#to').val(),
            status: $('#status').val(),
            type: $('#type').val(),
            _token: '{{csrf_token()}}'
        },
        success: function(res) {
            $('#show_all_fetchcheques').html(res);
            $('#example').DataTable({
                "pageLength": 10,
            });
        }
    })
}
$('#filter').on('click', function(e) {
    e.preventDefault();
    fetchsuppliercheques();
});
</script>

@endsection