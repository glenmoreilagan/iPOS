@extends('../index')

@section('title', 'Inventory Setup')
@section('content')
<h1 class="h3 mb-3">INVENTORY SETUP</h1>
<div class="card">
	<div class="card-header">
		<form method="POST" class="form-horizontal" role="form" action="/IS/setup">
			{{ csrf_field() }}
			<button class="btn btn-primary"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="is-list-table" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Docno</th>
					<th>Supplier</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody id="is-list"></tbody>
		</table>
	</div>
</div>
@endsection

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var table = $("#is-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		postData('/IS/getSetup', {})
	  .then(data => {
	    // console.log(data);
	    let td = '';
	    let ready_data = [];
	    for(let i in data) {
	    	ready_data.push([
	    		`<tr>
	    			<td>
	    				<button rowkey="${data[i].txid}" id="row-${data[i].txid}" class="btn btn-primary btn-sm btnview"><i class="far fa-eye"></i></button>
    				</td>
	    		</tr>`,
	    		data[i].docnum,
	    		data[i].supplier,
	    		data[i].dateid,
	    	]);
	    }
	    table.clear().rows.add(ready_data).draw();
	  }).catch((error) => {
	    console.log(error);
	  });

	  $(document).on("click", "#is-list .btnview", (e) => {
	  	let txid = e.currentTarget.attributes[0].nodeValue;
	  	window.location = `/IS/setup/${txid}`;
	  });


	});
</script>