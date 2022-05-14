@extends('index')

@section('content')
<h1 class="h3 mb-3">CATEGORY</h1>
<div class="card">
	<div class="card-header">
	</div>
	<div class="card-body">
		<table id="category-list-table" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody id="item-list"></tbody>
		</table>
	</div>
</div>
@endsection

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let table = $("#category-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		const getCategory = () => {
			postData('/category/getCategory', {})
		  .then(data => {
		    // console.log(data);
		    let td = '';
		    let ready_data = [];
		    for(let i in data) {
		    	ready_data.push([
		    		`<tr>
		    			<td>
		    				<button rowkey="${data[i].catid}" id="row-${data[i].catid}" class="btn-action btn btn-primary btn-sm btnviewItem"><i class="far fa-eye"></i></button>
	    				</td>
		    		</tr>`,
		    		data[i].category
		    	]);
		    }
		    table.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		getCategory();
	})
</script>