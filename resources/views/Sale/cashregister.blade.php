@extends('layouts.master')
@section('content')
<<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Cash Register</h4>
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
                    <a href="#">Cash Register</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Cash register</div>
                    </div>
                    <form id="" action="{{route('openregister')}}" method="POST">
                    @csrf
                        <div class="card-body">
                            <div class="col-offset-3">
                                <label for="cash_in_hand">Cash In hand</label>
                                <input type="number" class="form-control form-control-sm" tabindex=1 required name="cash_in_hand" id="cash_in_hand">
                            </div>
                        </div>
                        <div class="card-action ">
                            <button type="submit" class="btn btn-xs btn-success float-right mt--2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
