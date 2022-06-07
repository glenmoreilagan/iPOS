document.addEventListener("DOMContentLoaded", function() {
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

	const load_uom = (data) => {
		let input_itemid = $("input[name='itemid']").val();
		postData('/items/getUom', {data})
	  .then(res => {
	    let td = '';
	    let ready_data = [];
	    for(let i in res) {
    		ready_data.push([
	    		`<tr>
	    			<td>
	    				<button rowkey="${res[i].uomid}" id="row-${res[i].uomid}" class="btn-action btn btn-primary btn-sm btnSaveUom"><i class="far fa-eye"></i></button>
	    				<button rowkey="${res[i].uomid}" id="row-${res[i].uomid}" class="btn-action btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
    				</td>
	    		</tr>`,
	    		`<tr>
	    			<td>
	    				<span class="hide-me">${res[i].uom}</span>
	    				<input type="text" name="uom" id="uomrow-${res[i].uomid}" class="key-${res[i].uomid} uom-row-class form-control" value="${res[i].uom}"">
	    			</td>
	    		</tr>`,
	    		`<tr>
	    			<td>
	    				<input type="text" name="amt" id="amtrow-${res[i].uomid}" class="key-${res[i].uomid} uom-row-class form-control" value="${res[i].amt}"">
	    			</td>
	    		</tr>`,
	    	]);
	    }
	    uomtable.clear().rows.add(ready_data).draw();
	  }).catch((error) => {
	    console.log(error);
	  });
	}

	load_uom({itemid : $("input[name='itemid']").val()});

	$("#btnSave").click((e) => {
		e.preventDefault();

		if($("input[name='barcode']").val() == "" || $("input[name='itemname']").val() == "") {
			alert("REQUIRED");
			return;
		}

		let items_info = $(".txtitem_infohead").serializeArray();
		let ready_data_arr = [];
		let ready_data_obj = {};
		for(i in items_info) {
			ready_data_obj[items_info[i].name] = items_info[i].value;
		}
		ready_data_arr.push(ready_data_obj);

		postData('/items/saveItem', {data: ready_data_arr})
	  .then(data => {
	    // for (let i = 0; i < data.data.length; i++) {
	    	$("#lblitemid").text(data.data[0].itemid);
	    	$("input[name='itemid']").val(data.data[0].itemid);
	    	$("input[name='itemname']").val(data.data[0].itemname);
	    	$("input[name='barcode']").val(data.data[0].barcode);
	    	$("input[name='uomid']").val(data.data[0].uomid);
	    	$("input[name='uom']").val(data.data[0].uom);
	    // }
	    // console.log(itemid);
			load_uom({itemid:data.data[0].itemid});

			notify({status : data.status, message : data.msg});
	    // window.location = `/items/item/${data.data[0].itemid}`;
	  }).catch((error) => {
      console.log(error);
    });
	}); // end #btnSave

	
	$(document).on("click", "#uom-list .btnSaveUom", (e) => {
		let input_itemid = $("input[name='itemid']").val();
  	let row = e.currentTarget.attributes[0].nodeValue;
  	let uom = $("#uom-list .btnSaveUom").closest('tr').find(`td:eq(1) #uomrow-${row}`);
  	let amt = $("#uom-list .btnSaveUom").closest('tr').find(`td:eq(2) #amtrow-${row}`);

  	let uom_data = {itemid : input_itemid, uomid : row, uom : uom.val(), amt : amt.val()};

		postData('/items/saveUom', {data: uom_data})
	  .then(res => {
			// load_uom({itemid:input_itemid});
			uom.val(res.data[0].uom);
	  	amt.val(res.data[0].amt);
			$(`.key-${row}`).removeClass('isedited');
			notify({status : res.status, message : res.msg});
	  }).catch((error) => {
      console.log(error);
    });
  });

  $(document).on("change", ".uom-row-class", (e) => {
  	let row = e.currentTarget.id;
  	$(`#${row}`).addClass('isedited');
  });
});