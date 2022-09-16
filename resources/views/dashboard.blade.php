@php
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
$customer = Customer::where('status','=','Y')->count();
$product = Product::where('product_status','=','Y')->count();
$sale = Sale::where('status','=','Complete')->count();
$purchase = Purchase::where('status','=','Completed')->count();
use Carbon\Carbon;


$current_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->month)->count();

$before_1_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(1))->count();
$before_2_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(2))->count();
$before_3_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(3))->count();
$before_4_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(4))->count();
$before_5_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(5))->count();
$before_6_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(6))->count();
$before_7_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(7))->count();
$before_8_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(8))->count();
$before_9_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(9))->count();
$before_10_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(10))->count();
$before_11_month_sale = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->subMonth(11))->count();

$salescount = array($current_month_sale, $before_1_month_sale, $before_2_month_sale, $before_3_month_sale,
$before_4_month_sale, $before_5_month_sale, $before_6_month_sale, $before_7_month_sale, $before_8_month_sale,
$before_9_month_sale, $before_10_month_sale, $before_11_month_sale);

$current_month_purchase = Sale::whereYear('sale_date',Carbon::now()->year)
->whereMonth('sale_date',Carbon::now()->month)->count();

$before_1_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(1))->count();
$before_2_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(2))->count();
$before_3_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(3))->count();
$before_4_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(4))->count();
$before_5_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(5))->count();
$before_6_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(6))->count();
$before_7_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(7))->count();
$before_8_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(8))->count();
$before_9_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(9))->count();
$before_10_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(10))->count();
$before_11_month_purchase = Purchase::whereYear('purchase_date',Carbon::now()->year)
->whereMonth('purchase_date',Carbon::now()->subMonth(11))->count();

$purchasecounts = array($current_month_purchase, $before_1_month_purchase, $before_2_month_purchase, $before_3_month_purchase,
$before_4_month_purchase, $before_5_month_purchase, $before_6_month_purchase, $before_7_month_purchase, $before_8_month_purchase,
$before_9_month_purchase, $before_10_month_purchase, $before_11_month_purchase);

@endphp
@extends('layouts.master')
@section('content')
<?php
 $months = array();
 $count = 0;
 while($count <= 11)
 {
   $months[] = date('M Y', strtotime("-".$count."month"));
   $count++;
 }
$dataPoints = array(
	array("label"=> $months[11], "y"=> $salescount[11]),
	array("label"=> $months[10], "y"=> $salescount[10]),
	array("label"=> $months[9], "y"=> $salescount[9]),
	array("label"=> $months[8], "y"=> $salescount[8]),
	array("label"=> $months[7], "y"=> $salescount[7]),
	array("label"=> $months[6], "y"=> $salescount[6]),
	array("label"=> $months[5], "y"=> $salescount[5]),
	array("label"=> $months[4], "y"=> $salescount[4]),
	array("label"=> $months[3], "y"=> $salescount[3]),
	array("label"=> $months[2], "y"=> $salescount[2]),
	array("label"=> $months[1], "y"=> $salescount[1]),
	array("label"=> $months[0], "y"=> $salescount[0])
);
	
?>
<?php
/* echo $current_month = date('M Y', strtotime("-0 month"));
echo $current_month = date('M Y', strtotime("-1 month")); */
$months1 = array();
$count1 = 0;
while($count1 <= 11)
{
  $months1[] = date('M Y', strtotime("-".$count1."month"));
  $count1++;
}
/*  echo "<pre>"; print_r($purchasecounts); die; */
$dataPoints1 = array(
	array("y" => $purchasecounts[11], "label" => $months1[11]),
	array("y" => $purchasecounts[10], "label" => $months1[10]),
	array("y" => $purchasecounts[9], "label" => $months1[9]),
	array("y" => $purchasecounts[8], "label" => $months1[8]),
	array("y" => $purchasecounts[7], "label" => $months1[7]),
	array("y" => $purchasecounts[6], "label" => $months1[6]),
	array("y" => $purchasecounts[5], "label" => $months1[5]),
	array("y" => $purchasecounts[4], "label" => $months1[4]),
	array("y" => $purchasecounts[3], "label" => $months1[3]),
	array("y" => $purchasecounts[2], "label" => $months1[2]),
	array("y" => $purchasecounts[1], "label" => $months1[1]),
	array("y" => $purchasecounts[0], "label" => $months1[0]),
);
 
?>
<script>
window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: ""
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
        },
        axisY: {
            title: "Sale Number",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            }
        },
        toolTip: {
            enabled: false
        },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
	var chart1 = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
            text: ""
        },
        axisY: {
            includeZero: true
        },
        data: [{
            type: "area", //change type to bar, line, area, pie, etc
            //indexLabel: "{y}", //Shows y value on all Data Points
            indexLabelFontColor: "#5A5757",
            indexLabelPlacement: "outside",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart1.render();

}
</script>
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    <h5 class="text-white op-7 mb-2">Technors POS</h5>
                </div>
                <!--<div class="ml-md-auto py-2 py-md-0">x`
					<a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
					<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
				</div> -->
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="flaticon-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <h4 class="card-title">{{$customer}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="flaticon-interface-6"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Products</p>
                                    <h4 class="card-title">{{$product}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="flaticon-graph"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sales Invoices</p>
                                    <h4 class="card-title">{{$sale}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="flaticon-success"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Purchases</p>
                                    <h4 class="card-title">{{$purchase}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <center>
                            <h3>Monthly Sale Report</h3>
                        </center>
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
			<div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <center>
                        <h3>Purchase Report</h3>
                    </center>
                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
@section('Scripts')

<script>
Circles.create({
    id: 'circles-1',
    radius: 45,
    value: 60,
    maxValue: 100,
    width: 7,
    text: 5,
    colors: ['#f1f1f1', '#FF9E27'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

Circles.create({
    id: 'circles-2',
    radius: 45,
    value: 70,
    maxValue: 100,
    width: 7,
    text: 36,
    colors: ['#f1f1f1', '#2BB930'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

Circles.create({
    id: 'circles-3',
    radius: 45,
    value: 40,
    maxValue: 100,
    width: 7,
    text: 12,
    colors: ['#f1f1f1', '#F25961'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

var mytotalIncomeChart = new Chart(totalIncomeChart, {
    type: 'bar',
    data: {
        labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
        datasets: [{
            label: "Total Income",
            backgroundColor: '#ff9e27',
            borderColor: 'rgb(23, 125, 255)',
            data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            yAxes: [{
                ticks: {
                    display: false //this will remove only the label
                },
                gridLines: {
                    drawBorder: false,
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    drawBorder: false,
                    display: false
                }
            }]
        },
    }
});

$('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: 'line',
    height: '70',
    width: '100%',
    lineWidth: '2',
    lineColor: '#ffa534',
    fillColor: 'rgba(255, 165, 52, .14)'
});
</script>
@endsection