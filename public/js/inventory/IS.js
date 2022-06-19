document.addEventListener("DOMContentLoaded", function() {
		// let input_clientid = $("input[name='clientid']").val();
		const stocktable = $("#stock-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 25,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
			"ordering": false,
		});

		const itemlookup_table = $("#item-lookup-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 50,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
			"ordering": false
		});

		$(document).on('shown.bs.modal', (e) => {
		  itemlookup_table.columns.adjust();
		});

		const load_item = () => {
			postData('/IS/getItems', {})
		  .then(res => {
		    let td = '';
		    let ready_data = [];
		    for(let i in res) {
	    		ready_data.push([
		    		`<tr>
		    			<td>
		    				<input class="lookup-item-row" type="checkbox" name="id[]" value="${res[i].itemid}">
	    				</td>
		    		</tr>`,
		    		// `<tr>
		    		// 	<td>
		    		// 		<button rowkey="${res[i].itemid}" id="row-${res[i].itemid}" class="btn btn-primary btnSelectItem"><i class="far fa-eye"></i></button>
	    			// 	</td>
		    		// </tr>`,
		    		`<tr>
		    			<td>
		    				<span id="supprow-${res[i].itemid}">${res[i].barcode}</span>
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<span id="supprow-${res[i].itemid}">${res[i].itemname}</span>
		    			</td>
		    		</tr>`,
		    	]);
		    }
		    itemlookup_table.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		const load_stock = (txid) => {
			if (txid != 0) {
				postData('/IS/loadStock', {txid:txid})
			  .then(res => {
			  	// console.log(res);
			    let td = '';
			    let ready_data = [];
			    for(let i in res) {
		    		ready_data.push([
			    		`<tr>
			    			<td>
			    				<button rowkey="${res[i].line}" id="row-${res[i].line}" class="btn-action btn btn-primary btn-sm btnSaveStockItem"><i class="far fa-save"></i></button>
			    				<button rowkey="${res[i].line}" id="row-${res[i].line}" class="btn-action btn btn-danger btn-sm btnDeleteStockItem"><i class="far fa-trash-alt"></i></button>
		    				</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
			    				<span id="stock-barcode-row-${res[i].line}">${res[i].barcode}</span>
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
			    				<span id="stock-itemname-row-${res[i].line}">${res[i].itemname}</span>
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
			    				<span id="stock-uomid-row-${res[i].line}">${res[i].uom}</span>
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
				    			<input 
				    				rowkey="${res[i].line}" 
				    				type="text" 
				    				name="qty" 
				    				id="stock-qty-row-${res[i].line}" 
				    				class="key-${res[i].line} stock-row-class form-control text-right" 
				    				value="${res[i].qty}"
				    				onkeypress='numberOnly(event)'
				    			>
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
				    			<input 
				    				rowkey="${res[i].line}"
				    				type="text" 
				    				name="cost" 
				    				id="stock-cost-row-${res[i].line}" 
				    				class="key-${res[i].line} stock-row-class form-control text-right" 
				    				value="${res[i].cost}"
				    				onkeypress='numberOnly(event)'
				    			>
			    			</td>
			    		</tr>`
			    	]);
			    }
			    stocktable.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		const add_item = (data, txid) => {
			postData('/IS/addItem', {data:data, txid:txid})
		  .then(res => {
		  	if (res.status) {
			  	load_stock(txid);
			  	$("#lookupItem").modal('hide');
		  	}
		  	notify({status : res.status, message : res.msg});
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		load_stock($("input[name='txid']").val());

		$("#btnSave").click((e) => {
			e.preventDefault();

			if($("input[name='code']").val() == "" || $("input[name='name']").val() == "") {
				notify({status : false, message : "Required!"});
				return;
			}

			let txtsetup_info = $(".txtsetup_infohead").serializeArray();
			let ready_data_arr = [];
			let ready_data_obj = {};

			ready_data_obj['supplierid'] = $("input[name='supplier']").attr('supplierid');
			for(i in txtsetup_info) {
				ready_data_obj[txtsetup_info[i].name] = txtsetup_info[i].value;
			}
			ready_data_arr.push(ready_data_obj);

			postData('/IS/saveSetup', {data: ready_data_arr})
		  .then(data => {
		  	console.log(data);
		    // for (let i = 0; i < data.data.length; i++) {
		    	if (data.status) {
			    	$("#lbltxid").text(data.data[0].txid);
			    	$("input[name='txid']").val(data.data[0].txid);
			    	$("input[name='docnum']").val(data.data[0].docnum);
			    	$("input[name='supplier']").attr('supplierid', data.data[0].clientid);
			    	$("input[name='supplier']").val(data.data[0].supplier);
		    	}
		    // }
		    // console.log(clientid);
				notify({status : data.status, message : data.msg});
		    // window.location = `/suppliers/supplier/${data.data[0].clientid}`;
		  }).catch((error) => {
        console.log(error);
	    });
		});

		// Handle click on "Select all" control
		$('#select-all-item').on('click', function() {
		   // Get all rows with search applied
		   var rows = itemlookup_table.rows({ 'search': 'applied' }).nodes();
		   // Check/uncheck checkboxes for all rows in the table
		   $('input[type="checkbox"]', rows).prop('checked', this.checked);
		});

		let checkedItemId = [];
		$("#btnAddItemAccept").on("click", function() {
			// Iterate over all checkboxes in the table
		  itemlookup_table.$('.lookup-item-row').each(function() {
	      // If checkbox doesn't exist in DOM
	      // if(!$.contains(document, this)){
	        // If checkbox is checked
         	if(this.checked) {
         		checkedItemId.push(this.value);
         	}
		    // }
		  });
		  add_item(checkedItemId, $("input[name='txid']").val());
		  $("#btnlookupItem").modal('hide');
		  checkedItemId = [];
		});

		$("#btnlookupItem").click((e) => {
	  	e.preventDefault();

	  	let txid = $("input[name='txid']").val();

	  	if(txid == 0) {
	  		notify({status : false, message : "Please save transaction first!"});
	  		return false;
	  	}
	  	$("#lookupItem").modal('show');
	  	load_item();
	  });

	  $(document).on("click", "#stock-list .btnSaveStockItem", (e) => {
	  	let txid = $("input[name='txid']").val();
	  	let row = e.currentTarget.attributes[0].nodeValue;
	  	let qty = $("#stock-list .btnSaveStockItem").closest('tr').find(`td:eq(4) #stock-qty-row-${row}`);
	  	let cost = $("#stock-list .btnSaveStockItem").closest('tr').find(`td:eq(5) #stock-cost-row-${row}`);

	  	let stockdata_arr = [];
	  	let stockdata_obj = {};

	  	stockdata_obj['txid'] = txid;
	  	stockdata_obj['line'] = row;
	  	stockdata_obj['qty'] = qty.val();
			stockdata_obj['cost'] = cost.val();
	  	// qty.hasClass('isedited') ? stockdata_obj['qty'] = qty.val() : false;
	  	// cost.hasClass('isedited') ? stockdata_obj['cost'] = cost.val() : false;

	  	stockdata_arr.push(stockdata_obj);

			postData('/IS/saveStock', {data: stockdata_arr})
		  .then(res => {
		  	if (res.status) {
			  	qty.val(res.data.data[0].qty);
			  	cost.val(res.data.data[0].cost);
					$(`.key-${row}`).closest('tr').removeClass('isedited');
		  	}
				notify({status : res.status, message : res.msg});
		  }).catch((error) => {
        console.log(error);
	    });
	  });

	  $(document).on("change", ".stock-row-class", (e) => {
	  	let row = e.currentTarget.attributes[0].nodeValue;
	  	// let row = e.currentTarget.id;
	  	// $(`#${row}`).addClass('isedited');
	  	$(`.key-${row}`).closest('tr').addClass('isedited');
	  });

	  $("#btnPost").click((e) => {
	  	e.preventDefault();
	  	let txtid = $("input[name='txid']");

	  	postData('/IS/post', {txid: txtid.val()})
		  .then(data => {
		  	console.log(data);
				notify({status : data.status, message : data.msg});
		  }).catch((error) => {
        console.log(error);
	    });
	  });
	});