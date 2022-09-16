@extends('layouts.master')
@section('content')
<<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Cash Close</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Cash Close</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Cash Close</div>
                    </div>
                    <form id="frm_cash_close">
                    @csrf
                        <div class="card-body">
                            <div class="col">
                                <label for="cash_in_hand">User</label>
                                <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{Auth::user()->name}}" required name="user" id="user">
                                <label for="cash_in_hand">Cash In hand</label>
                                <input type="number" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{$reg->cash_in_hand}}" required name="cash_in_hand" id="cash_in_hand">
                                <label for="cash_in_hand">Total Sales</label>
                                <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{$sales_total}}" required name="total_sales" id="total_sales">
                                <label for="cash_in_hand">Cheques' Total</label>
                                <input type="text" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{$chequestotal}}"required name="total_cheques" id="total_cheques">
                                <label for="cash_in_hand">Total Return</label>
                                <input type="number" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{$totalreturn}}" required name="total_return" id="total_return">
                                <label for="cash_in_hand">Closing Amount</label>
                                <input type="number" class="form-control form-control-sm mb-2" tabindex=1 readonly value="{{$closing_amount}}" required name="closing_amount" id="closing_amount">
                            </div>
                        </div>
                        <div class="card-action ">
                            <button type="submit" class="btn btn-sm btn-danger float-right mt--3" id="btn_close">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Scripts')
<script>
    $('#frm_cash_close').submit(function(e){
        e.preventDefault();
        $('#btn_close').attr('disable',true);
        const cd=new FormData(this);
        $.ajax({
            url:'{{route('closeregister')}}',
            method:'post',
            data:cd,
            cache:false,
			processData:false,
			contentType:false,
            success:function(res)
            {
               if(res.status===200)
               {
                swal({
                    title: 'Success!',
                    text: "Cash register has benn closed successfully!",
                    icon: "success",
                    type: 'success',
                    buttons:{
                        confirm: {
                            text : 'OK',
                            className : 'btn btn-success'
                        }   
                    }
                    }).then((Delete) => {
                        if (Delete) {
                            window.location.href="dashboard"
                        } 
                    });
                }
            }
        })
    })
</script>
@endsection