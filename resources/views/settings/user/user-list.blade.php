@extends('../index')

@section('title', 'Users')
@section('content')
<h1 class="h3 mb-3">USERS</h1>
<div class="card">
	<div class="card-header">
		<form>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-user-info" id="btnmodal-user-info"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="datatables-reponsive" class="user-list-table table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Action</th>
				<th>Name</th>
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

<div class="modal fade" id="modal-user-info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">USER INFO</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body m-3">
				<div class="row">
				  <div class="col-md-6 mb-4">
					  <div class="mb-3">
							<label>Name</label>
							<input type="hidden" class="form-control txt_userinfo" id="" placeholder="Input Userid" name="userid" value="0">
							<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Name" name="name">
					  </div>
					  <div class="mb-3">
							<label>Email</label>
							<input type="email" class="form-control txt_userinfo" id="" placeholder="Input Email" name="email">
					  </div>
					  {{-- <div class="mb-3">
							<label>Address</label>
							<textarea class="form-control txt_userinfo" id="" placeholder="Input Address" rows="2" name="address"></textarea>
					  </div> --}}
					</div>

					<div class="col-md-6 mb-4">
						<div class="mb-3">
							<label>Username</label>
							<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Username" name="username">
					  </div>
					  <div class="mb-3">
							<label>Password</label>
							<input type="password" class="form-control txt_userinfo" id="" placeholder="Input Password" name="password">
					  </div>
					  <div class="mb-3">
							<label>Role</label>
	  					<div class="input-group">
								<input type="hidden" class="form-control txt_userinfo" id="" placeholder="Input RoleID" name="roleid" value="0">
								<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Role" name="role" readonly>
								<span class="input-group-append">
		            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupRoles" id="btnlookupRoles"><i data-feather="menu"></i></button>
			          </span>
			        </div>
					  </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSaveUser">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

@include('../lookups/roles-lookup')
@endsection
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let user_table = $(".user-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
			"aoColumnDefs": [{ "bVisible": false, "aTargets": [4] }]
		});

		let roles_lookup_table = $("#roles-lookup-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
			"ordering": false
		});

		const USER_OBJ =  {
			SAVE_USER : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
				  	USER_OBJ.LOAD_USER("/user/getUser", {data: {}});
			  		$("#modal-user-info").modal('hide');
			  	}
	        // console.log(res);
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			LOAD_USER : (url, data) => {
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
				    				class="btn-action btn btn-primary btn-sm btnviewUser" 
				    				data-toggle="modal" data-target="#modal-user-info">
				    				<i class="far fa-eye"></i>
			    				</button>
		    				</td>
			    		</tr>`,
			    		res[i].name, 
			    		res[i].email, 
			    		res[i].username, 
			    		res[i].password,
			    		res[i].role,
			    	]);
			    }
			    user_table.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			},
			EDIT_USER : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	// console.log(res);
			  	$("input[name='userid']").val(res[0].userid);
			  	$("input[name='email']").val(res[0].email);
			  	$("input[name='username']").val(res[0].username);
			  	$("input[name='password']").val(res[0].password);
			  	$("input[name='roleid']").val(res[0].roleid);
			  	$("input[name='role']").val(res[0].role);
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		const ROLE_OBJ = {
			LOAD_ROLES : (url, data) => {
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
				    				class="btn-action btn btn-primary btn-sm btnSelectRole">
				    				<i class="far fa-eye"></i>
			    				</button>
		    				</td>
			    		</tr>`,
			    		`<tr>
		    			<td>
		    				<span id="rolerow-${res[i].roleid}">${res[i].role}</span>
		    			</td>
		    		</tr>`
			    	]);
			    }
			    roles_lookup_table.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		// this function is to maximize width of the datatable in modal
		// if you encounter not filled whole width
		// https://stackoverflow.com/questions/36543622/datatables-in-bootstrap-modal-width
		$(document).on('shown.bs.modal', (e) => {
		   roles_lookup_table.columns.adjust();
		});

		USER_OBJ.LOAD_USER("/user/getUser", {data: {}});

		$("#btnlookupRoles").click((e) => {
	  	e.preventDefault();

			ROLE_OBJ.LOAD_ROLES("/user/getRole", {data: {}});
	  });

	  $(document).on("click", "#roles-lookup-list .btnSelectRole", (e) => {
	  	let rowkey = e.currentTarget.attributes[0].nodeValue;
	  	let role = $("#roles-lookup-list .btnSelectRole").closest('tr').find(`td:eq(1) #rolerow-${rowkey}`).text();

	  	console.log(rowkey, role);

	  	$("input[name='roleid']").val(rowkey);
    	$("input[name='role']").val(role);
    	$("#lookupRoles").modal('hide');
	  });

		$("#btnmodal-user-info").click((e) => {
			e.preventDefault();
			
			$(".txt_userinfo").val('');
			$("input[name='userid']").val(0);
		});



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

			USER_OBJ.SAVE_USER(url, {data: ready_data_arr});
		});

		$(document).on("click", ".btnviewUser", (e) => {
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			USER_OBJ.EDIT_USER("/user/getUser", {data: {userid: rowkey}});
		});
	})
</script>