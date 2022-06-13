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

	.dash-sum {
		/*border: 1px solid;*/
		height: 100px;
		display: flex;
		justify-content: space-between;
	}

	.dash-sum .child-dash-sum {
		padding: 1em;
		width: 24%;
		/*margin: 1em;*/
		/*border: 1px solid;*/
		background: #fff;
		display: flex;
		justify-content: space-around;
		box-shadow: 0 0 .875rem 0 rgba(41,48,66,.05);
	}

	.dash-sum .child-dash-sum .money {
		/*border: 1px solid;*/
		width: 50%;
		align-self: center;
	}

	.dash-sum .child-dash-sum .money h4 { 
		margin-top: 10px;
		font-size: 1.5em;
		font-weight: bold;
	}

	.money-icon {
		font-size: 32px;
		align-self: center;
	}
</style>
@extends('index')

@section('title', 'Dashboard')
@section('content')
<h1 class="h3 mb-3">DASHBOARD</h1>
<div class="dash-sum mb-3">
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4>1,000.00</h4>
			<small>Daily Sales</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-dollar-sign"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4>1,000.00</h4>
			<small>Annual Sales</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-dollar-sign"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4>1,000.00</h4>
			<small>Total Transaction</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-archive"></i></div>
	</div>
	<div class="child-dash-sum daily-sales">
		<div class="d-sales money">
			<h4>1,000.00</h4>
			<small>Users</small>
		</div>
		<div class="d-sales money-icon"><i class="fas fa-users"></i></div>
	</div>
</div>
<div class="card">
	<div class="card-header">
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-8">
				<h4>PREVIOUS YEAR VS CURRENT YEAR CHART</h4>
				<div id="annual-chart-div">
				  <canvas id="annual-chart"></canvas>
				</div>
			</div>
			<div class="col-md-4">
				<h4>WEEKLY CHART</h4>
				<div id="annual-chart-div">
				  <canvas id="daily_ctx-chart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const daily_ctx = document.getElementById('daily_ctx-chart').getContext('2d');
		const annual_ctx = document.getElementById('annual-chart').getContext('2d');
		const setChart = (labelss, monthss, datass, chart_display, chart_type) => {
			const annual_chart = new Chart(chart_display, {
		    type: chart_type,
		    data: {
	        labels: monthss,
	        datasets: [{
	          label: `${labelss[0]} Sales`,
	          data: datass[0],
	          backgroundColor: [
              'rgba(63, 128, 234, .5)',
	          ],
	          borderColor: [
	            'rgba(63, 128, 234, .5)',
	          ],
	          // borderWidth: 1,
	          // hoverBorderWidth : 3
	          // borderRadius: 0,
	        },{
	          label: `${labelss[1]} Sales`,
	          data: datass[1],
	          backgroundColor: [
	            'rgba(63, 128, 234, .8)',
	          ],
	          borderColor: [
	            'rgba(63, 128, 234, .8)',
	          ],
	          // borderWidth: 1,
	          // hoverBorderWidth : 3
	          // borderRadius: 0,
	        }]
		    },
		    options : {
	        scales : {
	          y: {
	            beginAtZero:true
	          }
	        },
	        responsive : true,
	        maintainAspectRatio: false,
	        plugins : {
	        	legend : {
	        		display : false
	        	},
	        	layout : {
	        		// padding : {
	        		// 	left : 50,
	        		// 	right : 50,
	        		// 	bottom : 50,
	        		// 	top : 50
	        		// }
	        	},
	      		tooltip: {
	      			// enabled : false
	      		}
	        }
		    }
			});
		}

		const get_annualchart = async (url = "/dashboard/annualChart", data = {}) => {
			let labelss = [];
			let datass = [];
			let monthss = [
				'Jan', 'Feb', 
				'Mar', 'Apr', 
				'May', 'Jun', 
				'Jul', 'Aug', 
				'Sep', 'Oct', 
				'Nov', 'Dec'
			];
			await postData(url, data)
		  .then(res => {
		  	for(let i in res) {
		  		labelss.push(res[i].year);
		  		datass.push([
		  			res[i].january,
		  			res[i].february,
		  			res[i].march,
		  			res[i].april,
		  			res[i].may,
		  			res[i].june,
		  			res[i].july,
		  			res[i].august,
		  			res[i].september,
		  			res[i].october,
		  			res[i].november,
		  			res[i].december
		  		]);
		  	}
		  	// console.log(monthss);
		  	// console.log(datass[0]);
		  	setChart(labelss, monthss, datass, annual_ctx, 'bar');
		  	let weeks = [
					'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
				];
		  	setChart(labelss, weeks, datass, daily_ctx, 'line');
		  }).catch((error) => {
		    console.log(error);
		  });
		}
		get_annualchart();

	});
</script>