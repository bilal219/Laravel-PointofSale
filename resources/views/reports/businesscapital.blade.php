@extends('layouts.master')
@section('content')

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Business Capital Report</h4>
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
                    <a href="#">Business Capital</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <div class="container1">
                <center>
                    <h1><b> Technors POS </b></h1>
                    <p>Mumtaz Market Gujranwala</p>
                    <h3><u> BUSINESS CAPITAL</u></h3>
                </center>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">


                    <div class="card card-body card-outline">
                        <div class="card-body">
                            <br>
                            <div class="table-responsive" id="show_all_fetchcapital">
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
fetchcapital();
function fetchcapital() {
    $.ajax({
        url: "{{route('fetchcapital')}}",
        method: 'get',
        
        success: function(res) {
            $('#show_all_fetchcapital').html(res);
            $('#example').DataTable({
                "pageLength": 10,
            });
        }
    })
}
</script>

@endsection