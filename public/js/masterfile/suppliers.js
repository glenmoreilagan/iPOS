document.addEventListener("DOMContentLoaded", function() {
	// let input_clientid = $("input[name='clientid']").val();
	var uomtable = $("#uom-list-table").DataTable({
		responsive: true,
		"dom": '<"top"f>rt<"bottom"ip><"clear">',
		"pageLength": 25,
		"scrollY" : "250px",
		"scrollX" : true,
		"scrollCollapse" : true,
		"fixedHeader" : true,
		"ordering": false
	});

	$("#btnSave").click((e) => {
		e.preventDefault();

		if($("input[name='code']").val() == "" || $("input[name='name']").val() == "") {
			alert("REQUIRED");
			return;
		}

		let suppliers_info = $(".txtsupplier_infohead").serializeArray();
		let ready_data_arr = [];
		let ready_data_obj = {};
		for(i in suppliers_info) {
			ready_data_obj[suppliers_info[i].name] = suppliers_info[i].value;
		}
		ready_data_arr.push(ready_data_obj);

		postData('/suppliers/saveSupplier', {data: ready_data_arr})
	  .then(data => {
	    // for (let i = 0; i < data.data.length; i++) {
	    	$("#lblclientid").text(data.data[0].clientid);
	    	$("input[name='clientid']").val(data.data[0].clientid);
	    	$("input[name='name']").val(data.data[0].name);
	    	$("input[name='code']").val(data.data[0].code);
	    	$("input[name='name']").val(data.data[0].name);
	    	$("input[name='address']").val(data.data[0].address);
	    // }
	    // console.log(clientid);
			notify({status : data.status, message : data.msg});
	    // window.location = `/suppliers/supplier/${data.data[0].clientid}`;
	  }).catch((error) => {
      console.log(error);
    });
	}); // end #btnSave
});