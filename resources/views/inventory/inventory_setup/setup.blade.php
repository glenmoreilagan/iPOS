<head>
	<style type="text/css">
		.txtnumber {
			width: 15px;
		}

		.stock-row-class.isedited {
			background-color: #C7E8CE;
		}
	</style>
</head>
@extends('index')

@section('title', 'Inventory Setup')
@section('content')
<h1 class="h3 mb-3">INVENTORY SETUP</h1>
<div class="card mb-3">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/IS/setup">
				{{ csrf_field() }}
				<button class="btn btn-primary" id="btnNew"><i data-feather="file-plus"></i> New</button>
				<button class="btn btn-primary" id="btnSave"><i data-feather="save"></i> Save</button>
				<button class="btn btn-primary" id="btnDelete"><i data-feather="trash"></i> Delete</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		@php
			// echo "<pre>";
			// print_r($head);
			$txid = isset($head[0]["txid"]) ? $head[0]["txid"] : 0;
			$docnum = isset($head[0]["docnum"]) ? $head[0]["docnum"] : "";
			$supplierid = isset($head[0]["supplierid"]) ? $head[0]["supplierid"] : 0;
			$supplier = isset($head[0]["supplier"]) ? $head[0]["supplier"] : '';
			$dateid = isset($head[0]["dateid"]) ? $head[0]["dateid"] : '';
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Document # <sup id="lbltxid">{{ $txid }}</sup></label>
					<div class="input-group">
						<input name="txid" type="hidden" class="form-control txtsetup_infohead" id="" placeholder="Input txid" value="{{ $txid }}">
						<input name="docnum" type="text" class="form-control txtsetup_infohead" id="" placeholder="Input Document #" value="{{ $docnum }}">
					</div>
					<label>Supplier</label>
					<div class="input-group">
						<input name="supplier" type="text" class="form-control txtsetup_infohead" id="" placeholder="Input Supplier" value="{{ $supplier }}" supplierid="{{ $supplierid }}" readonly>
						<span class="input-group-append">
            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupSupplier" id="btnlookupSupplier"><i data-feather="menu"></i></button>
	          </span>
					</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="mb-3">
			  	<label>Date</label>
			  	<div class="input-group">
						<input name="dateid" type="date" class="form-control txtsetup_infohead" id="" value="{{ $dateid }}">
					</div>
			  </div>
			</div>
		</div>
	</div>
</div>

<div class="card mb-3">
	{{-- <div class="card-header">
	</div> --}}
	<div class="card-body">
		<div class="tab tab-primary stock-list-tab">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#tab-1" data-toggle="tab" role="tab">INVENTORY TAB</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1" role="tabpanel">
					<div class="tab-buttons-headder mb-3">
						<button class="btn btn-primary" id="btnlookupItem"><i data-feather="plus"></i> Add Item</button>
					</div>
					<table id="stock-list-table" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th style="width: 100px;">Action</th>
								<th style="width: 100px;">Barcode</th>
								<th style="width: 150px;">Itemname</th>
								<th style="width: 50px;">UOM</th>
								<th style="width: 100px;">Quantity</th>
								<th style="width: 100px;">Cost</th>
							</tr>
						</thead>
						<tbody id="stock-list"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('../lookups/supplier-lookup')
@include('../lookups/item-lookup')
@endsection

<script type="text/javascript">
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
			    				<button rowkey="${res[i].line}" id="row-${res[i].line}" class="btn btn-primary btnSaveStockItem"><i class="far fa-save"></i></button>
			    				<button rowkey="${res[i].line}" id="row-${res[i].line}" class="btn btn-danger btnDeleteStockItem"><i class="far fa-trash-alt"></i></button>
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
			    				<span id="stock-uomid-row-${res[i].line}">${res[i].uomid}</span>
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
				    			<input type="text" name="qty" id="stock-qty-row-${res[i].line}" class="key-${res[i].line} stock-row-class form-control text-right" value="${res[i].qty}"">
			    			</td>
			    		</tr>`,
			    		`<tr>
			    			<td>
				    			<input type="text" name="cost" id="stock-cost-row-${res[i].line}" class="key-${res[i].line} stock-row-class form-control text-right" value="${res[i].cost}"">
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
			  	notify({status : res.status, message : res.msg});
			  	$("#lookupItem").modal('hide');
		  	}
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
		    	$("#lbltxid").text(data.data[0].txid);
		    	$("input[name='txid']").val(data.data[0].txid);
		    	$("input[name='docnum']").val(data.data[0].docnum);
		    	$("input[name='supplier']").attr('supplierid', data.data[0].clientid);
		    	$("input[name='supplier']").val(data.data[0].supplier);
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
	  	qty.hasClass('isedited') ? stockdata_obj['qty'] = qty.val() : false;
	  	cost.hasClass('isedited') ? stockdata_obj['cost'] = cost.val() : false;

	  	stockdata_arr.push(stockdata_obj);

			postData('/IS/saveStock', {data: stockdata_arr})
		  .then(res => {
		  	qty.val(res.data.data[0].qty);
		  	cost.val(res.data.data[0].cost);
				notify({status : res.status, message : res.msg});
				$(`.key-${row}`).removeClass('isedited');
		  }).catch((error) => {
        console.log(error);
	    });
	  });

	  $(document).on("change", ".stock-row-class", (e) => {
	  	let row = e.currentTarget.id;
	  	$(`#${row}`).addClass('isedited');
	  });
	});
</script>