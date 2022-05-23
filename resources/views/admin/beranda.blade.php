@extends('admin/layout')
@section('konten')

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">
		
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
	</ol>
	</ol>
	</section>
	
	<section class="content">
	
	<div class="box-body">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-4 col-xs-12">
				<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
						<h3>{{ $guest_book }}</h3>

						<p>Total Tamu</p>
						</div>
						<div class="icon">
						<i class="fa fa-users"></i>
						</div>
						<a href="{{ url('guest_book') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-12">
				<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
						<h3>{{ $incoming_mail }}</h3>

						<p>Total Surat Masuk</p>
						</div>
						<div class="icon">
						<i class="fa fa-envelope"></i>
						</div>
						<a href="{{ url('incoming_mail') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-12">
				<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
						<h3>{{ $outgoing_mail }}</h3>

						<p>Total Surat Keluar</p>
						</div>
						<div class="icon">
						<i class="fa fa-envelope"></i>
						</div>
						<a href="{{ url('outgoing_mail') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-12 col-xs-12">
				<!-- small box -->
					<div class="small-box" style="background-color: #ffffff !important;">
						<p style="text-align:center;font-size:20px;font-weight:bold;margin-inline: auto;color:#000000">SURVEY KEPUASAN TENTANG PELAYANAN SEKOLAH </p>
                              <div id="chartdiv"></div>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
	</section>
</div>

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 300px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

@php
    $memuaskan = DB::table('surveys')->where('survey',3)->count();
    $cukup = DB::table('surveys')->where('survey',2)->count();
    $kurang = DB::table('surveys')->where('survey',1)->count();
@endphp

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
chart.data = [{
  "country": "Memuaskan",
  "litres": {{ $memuaskan }},
  "color": am4core.color("#00a65a")
},{
  "country": "Cukup",
  "litres": {{ $cukup }},
  "color": am4core.color("#f39c12")
}, {
  "country": "Kurang",
  "litres": {{ $kurang }},
  "color": am4core.color("#dd4b39")
}];

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

chart.hiddenState.properties.radius = am4core.percent(0);


// Put a thick white border around each Slice
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template
  // change the cursor on hover to make it apparent the object can be interacted with
  .cursorOverStyle = [
    {
      "property": "cursor",
      "value": "pointer"
    }
  ];

pieSeries.alignLabels = false;
pieSeries.labels.template.bent = true;
pieSeries.labels.template.radius = 3;
pieSeries.labels.template.padding(0,0,0,0);

pieSeries.ticks.template.disabled = true;

// Create a base filter effect (as if it's not there) for the hover to return to
var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
shadow.opacity = 0;

// Create hover state
var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

// Slightly shift the shadow and make it more prominent on hover
var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
hoverShadow.opacity = 0.7;
hoverShadow.blur = 5;

chart.legend = new am4charts.Legend();

pieSeries.colors.list = [
  am4core.color("#00a65a"),
  am4core.color("#f39c12"),
  am4core.color("#dd4b39")
];

}); // end am4core.ready()
</script>    
@endsection