@php
use App\Models\ClientDetails;
$rpt_data=ClientDetails::latest('id')->first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="modal-content">   
        <div class="modal-body" id="printreport">
            <!-- rendring -->
            <center class="mt-3">
                <h3><strong>{{$rpt_data->Bus_Name ?? 'Technic Mentors'}}</strong></h3>
                <h5>{{$rpt_data->Bus_Address ?? 'Mumtaz Market Gujranwala'}}</h4>
            </center>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="panel panel-default">
                        <div class="panel-heading d-flex">
                            <center><h3 class="panel-title mx-auto"><strong><u id="rpt_name">Report Name</u></strong></h3></center>
                        </div>
                        <div class="d-flex">
                            <p ><strong id="rpt_param"></strong></p>
                            <p class="ml-auto">
                                <strong id="rpt_from" class="mx-3"></strong>
                                <strong id="rpt_to" class="mx-3"></strong>
                            </p>
                        </div>
                        <div class="panel-body mt--3">
                            <div class="table-responsive" id="rpt_body">
                                
                            </div>
                        </div>
                        <div id="rpt_footer" class="my-4 d-flex">
                            <!-- //rendring footer info  -->
                        </div>
                        <div class="col-md-6 ml-auto mr-auto text-center mb-4" id="bus_msg">
                                                                
                        </div>
                        <footer style="bottom:20%">
                            <center>
                                <strong> Software Developed </strong><small>with love by</small><strong>Technic Mentors</strong>&nbsp;|&nbsp; 0300-4900046
                            </center>
                        </footer>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</body>
</html>