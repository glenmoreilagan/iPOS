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
		  		$(".txt_userinfo").val('');
					$("input[name='userid']").val(0);
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