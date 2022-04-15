@extends('../index')

@section('content')
<h1 class="h3 mb-3">ITEMS</h1>
<div class="card">
	<div class="card-header">
		<form method="POST" class="form-horizontal" role="form" action="/items/item">
			{{ csrf_field() }}
			<button class="btn btn-primary"><i class="far fa-save"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="items-list-table" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Barcode</th>
					<th>Itemname</th>
					<th>UOM</th>
				</tr>
			</thead>
			<tbody id="item-list"></tbody>
		</table>
	</div>
</div>
@endsection

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var table = $("#items-list-table, newtable").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		postData('/items/getItems', {})
	  .then(data => {
	    // console.log(data);
	    let td = '';
	    let ready_data = [];
	    for(let i in data) {
	    	ready_data.push([
	    		`<tr>
	    			<td>
	    				<button rowkey="${data[i].itemid}" id="row-${data[i].itemid}" class="btn btn-primary btn-sm btnviewItem"><i class="far fa-eye"></i></button>
    				</td>
	    		</tr>`,
	    		data[i].barcode, 
	    		data[i].itemname,
	    		data[i].uomid,
	    	]);
	    }
	    table.clear().rows.add(ready_data).draw();
	  }).catch((error) => {
	    console.log(error);
	  });

	  $(document).on("click", "#item-list .btnviewItem", (e) => {
	  	let itemid = e.currentTarget.attributes[0].nodeValue;
	  	window.location = `/items/item/${itemid}`;
	  });


	});
</script>