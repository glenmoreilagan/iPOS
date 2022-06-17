document.addEventListener("DOMContentLoaded", function() {
	let high_stock_table = $("#high-stock-table").DataTable({
		responsive: true,
		// "dom": '<"top"f>rt<"bottom"ip><"clear">',
		"dom": '<"top">rt<"bottom"><"clear">',
		"pageLength": 10,
		"scrollY" : "250px",
		"scrollX" : true,
		"scrollCollapse" : true,
		"fixedHeader" : true,
		"ordering": false
	});

	let low_stock_table = $("#low-stock-table").DataTable({
		responsive: true,
		// "dom": '<"top"f>rt<"bottom"ip><"clear">',
		"dom": '<"top">rt<"bottom"><"clear">',
		"pageLength": 10,
		"scrollY" : "250px",
		"scrollX" : true,
		"scrollCollapse" : true,
		"fixedHeader" : true,
		"ordering": false
	});

	const weekly_ctx = document.getElementById('weekly_ctx-chart').getContext('2d');
	const annual_ctx = document.getElementById('annual-chart').getContext('2d');

	const get_summary_panel = async (url = "/dashboard/summarydata", data = {}) => {
		await postData(url, data)
	  .then(res => {
	  	if (res.status) {
	  		$("#d-sale-label").text(res.data.daily_sale);
	  		$("#annual-sale-label").text(res.data.annual_sale);
	  		$("#total-trans-label").text(res.data.total_trans);
	  		$("#user-count-label").text(res.data.total_users);
	  	}
	  }).catch((error) => {
	    console.log(error);
	  });
	}

	get_summary_panel();

	const get_high_low_panel = async (url = "/dashboard/highLowStocks", data = {}) => {
		await postData(url, data)
	  .then(res => {
	  	if (res.status) {
	  		// high_stocks
		    let high_stocks_data = [];
		    for(let i in res.data.high_stocks) {
		    	high_stocks_data.push([
		    		res.data.high_stocks[i].barcode, 
		    		res.data.high_stocks[i].itemname,
		    		res.data.high_stocks[i].uom,
		    		res.data.high_stocks[i].bal,
		    	]);
		    }
		    high_stock_table.clear().rows.add(high_stocks_data).draw();

	  		// low_stocks
		    let low_stocks_data = [];
		    for(let i in res.data.low_stocks) {
		    	low_stocks_data.push([
		    		res.data.low_stocks[i].barcode, 
		    		res.data.low_stocks[i].itemname,
		    		res.data.low_stocks[i].uom,
		    		res.data.low_stocks[i].bal,
		    	]);
		    }
		    low_stock_table.clear().rows.add(low_stocks_data).draw();
	  	}
	  }).catch((error) => {
	    console.log(error);
	  });
	}

	get_high_low_panel();

	const setChart = (labelss, monthss, datass, chart_display, chart_type) => {
		const annual_chart = new Chart(chart_display, {
	    type: chart_type,
	    data: {
        labels: monthss,
        datasets: datass
	    },
	    options : {
        scales : {
        	x: {
      	    grid: {
      	      display: false
      	    }
      	  },
          y: {
            beginAtZero : true,
            grid: {
              // display: false
            }
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

	const get_chart = async (url = "/dashboard/annualChart", data = {}) => {
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
		let weeks = [
			'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'
		];
		await postData(url, data)
	  .then(res => {
	  	for(let i in res.annual) {
	  		labelss.push(res.annual[i].year);
	  		datass.push([
	  			res.annual[i].january,
	  			res.annual[i].february,
	  			res.annual[i].march,
	  			res.annual[i].april,
	  			res.annual[i].may,
	  			res.annual[i].june,
	  			res.annual[i].july,
	  			res.annual[i].august,
	  			res.annual[i].september,
	  			res.annual[i].october,
	  			res.annual[i].november,
	  			res.annual[i].december
	  		]);
	  	}
	  	// console.log(monthss);
	  	// console.log(datass[0]);

	  	let ann_data = [
	  		{
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
        },{
          label: `${labelss[2]} Sales`,
          data: datass[2],
          backgroundColor: [
            'rgba(64, 90, 144, .8)',
          ],
          borderColor: [
            'rgba(64, 90, 144, .8)',
          ],
          // borderWidth: 1,
          // hoverBorderWidth : 3
          // borderRadius: 0,
        }
      ];
	  	setChart(labelss, monthss, ann_data, annual_ctx, 'bar');
	  	labelss = [];
	  	monthss = [];
	  	datass = [];

	  	for(let i in res.weekly) {
	  		labelss.push(res.weekly[i].year);
	  		datass.push([
	  			res.weekly[i].mon,
	  			res.weekly[i].tue,
	  			res.weekly[i].wed,
	  			res.weekly[i].thu,
	  			res.weekly[i].fri,
	  			res.weekly[i].sat,
	  			res.weekly[i].sun
	  		]);
	  	}

	  	let week_data = [
	  		{
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
        }
      ];
	  	setChart(labelss, weeks, week_data, weekly_ctx, 'line');
	  }).catch((error) => {
	    console.log(error);
	  });
	}
	get_chart();

});