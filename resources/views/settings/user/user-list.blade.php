@extends('../index')

@section('title', 'Users')
@section('content')
<h1 class="h3 mb-3">USERS</h1>
<div class="card">
	<div class="card-header">
		<button class="btn btn-primary" data-toggle="modal" data-target="#modal-user-info" id="btnmodal-user-info"><i data-feather="file-plus"></i> New</button>
	</div>
	<div class="card-body">
		<table id="datatables-reponsive" class="user-list-table table table-striped" style="width:100%">
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
							<label>Address</label>
							<textarea class="form-control txt_userinfo" id="" placeholder="Input Address" rows="2" name="address"></textarea>
					  </div>
					  <div class="mb-3">
							<label>Email</label>
							<input type="email" class="form-control txt_userinfo" id="" placeholder="Input Email" name="email">
					  </div>
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
@endsection
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let table = $(".user-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
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
			EDIT_USER : (url, data) => {
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

		USER_OBJ.LOAD_USER("/user/getUser", {data: {}});

		$("#btnmodal-user-info").click((e) => {
			$(".txt_userinfo").val('');
			$("input[name='userid']").val(0);
		})

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