@extends('index')
<style type="text/css">
	#annual-chart-div {
    position: relative;
    margin: auto;
	  height: 50vh;
	  width: 100%;
	}

	#annual-chart {
		position: absolute;
		width: 100% !important;
		height: 100% !important;
	}
</style>
@section('content')
<h1 class="h3 mb-3">DASHBOARD</h1>
<div class="card">
	<div class="card-header">
		<h4>PREVIOUS YEAR vs CURRENT YEAR SALES</h4>
	</div>
	<div class="card-body">
		<div id="annual-chart-div">
		  <canvas id="annual-chart"></canvas>
		</div>
	</div>
</div>
@endsection

