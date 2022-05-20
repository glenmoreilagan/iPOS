@extends('../index')

@section('title', 'Roles')
@section('content')
<h1 class="h3 mb-3">ROLES</h1>
<div class="card">
	<div class="card-header">
		<form method="POST" class="form-horizontal" role="form" action="/roles/role">
			{{ csrf_field() }}
			<button class="btn btn-primary"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="datatables-reponsive" class="role-list-table table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Action</th>
				<th>Role</th>
			</tr>
		</thead>
		<tbody class="role-list"></tbody>
	</table>
	</div>
</div>

@endsection
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let table = $(".role-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		const ROLE_OBJ =  {
			LOAD_ROLE : (url, data) => {
				postData(url, data)
			  .then(res => {
			    // console.log(res);
			    let td = '';
			    let ready_data = [];
			    for(let i in res) {
			    	ready_data.push([
			    		`<tr>
			    			<td>
			    				<button 
				    				rowkey="${res[i].roleid}" 
				    				id="row-${res[i].roleid}" 
				    				class="btn-action btn btn-primary btn-sm btnviewRole" 
				    				data-toggle="modal" data-target="#modal-user-info">
				    				<i class="far fa-eye"></i>
			    				</button>
		    				</td>
			    		</tr>`,
			    		res[i].role
			    	]);
			    }
			    table.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		ROLE_OBJ.LOAD_ROLE("/roles/getRoles", {data: {}});

		$(document).on("click", ".btnviewRole", (e) => {
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			window.location = `/roles/role/${rowkey}`;
		});
	})
</script>