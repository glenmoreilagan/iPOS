@extends('../index')

@section('title', 'Users')
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
				<th>Email</th>
				<th>Username</th>
				<th>Password</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody class="user-list"></tbody>
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
			SAVE_ROLE : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
				  	ROLE_OBJ.LOAD_ROLE("/user/getUser", {data: {}});
			  		$("#modal-user-info").modal('hide');
			  	}
	        // console.log(res);
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			LOAD_ROLE : (url, data) => {
				postData(url, data)
			  .then(res => {
			    // console.log(data);
			    let td = '';
			    let ready_data = [];
			    for(let i in res) {
			    	ready_data.push([
			    		`<tr>
			    			<td>
			    				<button 
				    				rowkey="${res[i].userid}" 
				    				id="row-${res[i].userid}" 
				    				class="btn-action btn btn-primary btn-sm btnviewRole" 
				    				data-toggle="modal" data-target="#modal-user-info">
				    				<i class="far fa-eye"></i>
			    				</button>
		    				</td>
			    		</tr>`,
			    		res[i].email, 
			    		res[i].username, 
			    		res[i].password,
			    		res[i].status,
			    	]);
			    }
			    table.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			},
			EDIT_ROLE : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	// console.log(res);
			  	$("input[name='userid']").val(res[0].userid);
			  	$("input[name='email']").val(res[0].email);
			  	$("input[name='username']").val(res[0].username);
			  	$("input[name='password']").val(res[0].password);
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		ROLE_OBJ.LOAD_ROLE("/user/getUser", {data: {}});

		$(document).on("click", "#btnSaveUser", (e) => {
			const url = "/user/setUser";
			let user_info = $(".txt_userinfo").serializeArray();


			$(".txt_userinfo").val('');
			$("input[name='userid']").val(0);

			let ready_data_arr = [];
			let ready_data_obj = {};
			for(i in user_info) {
				ready_data_obj[user_info[i].name] = user_info[i].value;
			}
			ready_data_arr.push(ready_data_obj);

			ROLE_OBJ.SAVE_ROLE(url, {data: ready_data_arr});
		});

		$(document).on("click", ".btnviewRole", (e) => {
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			ROLE_OBJ.EDIT_ROLE("/user/getUser", {data: {userid: rowkey}});
		});
	})
</script>