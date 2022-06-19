@extends('index')

@section('title', 'Dashboard')
@section('content')
<h1 class="h3 mb-3">DASHBOARD</h1>
<div class="dash-sum mb-3">
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4 id="d-sale-label">0</h4>
			<small>Daily Sales</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-dollar-sign"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4 id="annual-sale-label">0</h4>
			<small>Annual Sales</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-dollar-sign"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4 id="total-trans-label">0</h4>
			<small>Total Transaction</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-archive"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4 id="user-count-label">0</h4>
			<small>Users</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-users"></i></div>
	</div>
</div>

<div class="chart-div">
	<div class="row">
		<div class="col-md-8 mb-3">
			<h4 class="chart-label">PREVIOUS YEAR VS CURRENT YEAR CHART</h4>
			<div id="annual-chart-div">
			  <canvas id="annual-chart"></canvas>
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<h4 class="chart-label">WEEKLY CHART</h4>
			<div id="annual-chart-div">
			  <canvas id="weekly_ctx-chart"></canvas>
			</div>
		</div>
	</div>
</div>

<div class="stock-level-div mt-3">
	<div class="row">
		<div class="col-md-6 mb-3">
			<h4 class="chart-label">TOP 10 HIGH STOCK</h4>
			<div id="high-stock-div">
			  <table id="high-stock-table" class="table stock-level-table" style="width:100%">
			  	<thead>
			  		<tr>
			  			<th>Barcode</th>
			  			<th>Itemname</th>
			  			<th>UOM</th>
			  			<th>Balance</th>
			  		</tr>
			  	</thead>
			  	<tbody id="high-stock-list"></tbody>
			  </table>
			</div>
		</div>
		<div class="col-md-6 mb-3">
			<h4 class="chart-label"> TOP 10 LOW STOCK</h4>
			<div id="low-stock-div">
				<table id="low-stock-table" class="table stock-level-table" style="width:100%">
					<thead>
						<tr>
							<th>Barcode</th>
							<th>Itemname</th>
							<th>UOM</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody id="low-stock-list"></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
<script type="text/javascript" src="/js/dashboard/dashboard.js"></script>