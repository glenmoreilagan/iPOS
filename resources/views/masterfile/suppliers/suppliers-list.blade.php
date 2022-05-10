@extends('../index')

@section('title', 'Suppliers')
@section('content')
<h1 class="h3 mb-3">SUPPLIERS</h1>
<div class="card">
	<div class="card-header">
		<form method="POST" class="form-horizontal" role="form" action="/suppliers/supplier">
			{{ csrf_field() }}
			<button class="btn btn-primary"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="supplier-list-table" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Supplier Code</th>
					<th>Supplier Name</th>
					<th>Address</th>
				</tr>
			</thead>
			<tbody id="supplier-list"></tbody>
		</table>
	</div>
</div>
@endsection

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var table = $("#supplier-list-table, newtable").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		postData('/suppliers/getSuppliers', {})
	  .then(data => {
	    // console.log(data);
	    let td = '';
	    let ready_data = [];
	    for(let i in data) {
	    	ready_data.push([
	    		`<tr>
	    			<td>
	    				<button rowkey="${data[i].clientid}" id="row-${data[i].clientid}" class="btn-action btn btn-primary btn-sm btnviewSupplier"><i class="far fa-eye"></i></button>
    				</td>
	    		</tr>`,
	    		data[i].code, 
	    		data[i].name,
	    		data[i].address,
	    	]);
	    }
	    table.clear().rows.add(ready_data).draw();
	  }).catch((error) => {
	    console.log(error);
	  });

	  $(document).on("click", "#supplier-list .btnviewSupplier", (e) => {
	  	// e.currentTarget.attributes[0].nodeValue;
	  	// is the 1st element of the html tag. 
	  	// this result is the value of rowkey="${data[i].clientid}
	  	let itemid = e.currentTarget.attributes[0].nodeValue;
	  	window.location = `/suppliers/supplier/${itemid}`;
	  });


	});
</script>