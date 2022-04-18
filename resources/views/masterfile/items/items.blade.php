<head>
	<style type="text/css">
		.headbtns > button {
			width: 150px;
		}
		.tab-primary .tab-content, .tab-title {
			background: #ffffff !important;
    	color: #6c757d !important;
		}
		.uom-list-tab .nav-tabs .nav-link {
			padding: 5px 10px 5px 10px !important;
		}
		.hide-me {
			display: none;
		}
	</style>
</head>
@extends('index')

@section('content')
<h1 class="h3 mb-3">ITEMS</h1>
<div class="card">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/items/item">
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
			// print_r($items);
			$itemid = isset($items[0]["itemid"]) ? $items[0]["itemid"] : 0;
			$itemname = isset($items[0]["itemname"]) ? $items[0]["itemname"] : '';
			$barcode = isset($items[0]["barcode"]) ? $items[0]["barcode"] : '';
			$uomid = isset($items[0]["uomid"]) ? $items[0]["uomid"] : 0;
			$uom = isset($items[0]["uom"]) ? $items[0]["uom"] : '';
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode <sup id="lblitemid">{{ $itemid }}</sup></label>
					<div class="input-group">
						<input name="itemid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input itemid" value="{{ $itemid }}">
						<input name="barcode" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Barcode" value="{{ $barcode }}">
					</div>

					<label>Item Name</label>
					<div class="input-group">
						<input name="itemname" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Item Name" value="{{ $itemname }}">
					</div>

					<label>Default UOM</label>
					<div class="input-group">
							<input name="uom" type="text" class="form-control txtitem_infohead" id="" placeholder="Input UOM" value="{{ $uom }}">
							<span class="input-group-append">
	            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupUom" id="btnlookupUom"><i data-feather="menu"></i></button>
	          </span>
					</div>

			  </div>
			</div>
		</div>

		<div class="tab tab-primary uom-list-tab mt-5">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#tab-1" data-toggle="tab" role="tab">UOM</a></li>
				<li class="nav-item"><a class="nav-link" href="#tab-2" data-toggle="tab" role="tab">TAB1</a></li>
				<li class="nav-item"><a class="nav-link" href="#tab-3" data-toggle="tab" role="tab">TAB2</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1" role="tabpanel">
					{{-- <h4 class="tab-title">UOM</h4> --}}
					<table id="uom-list-table" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Action</th>
								<th>UOM</th>
								<th>Cost</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody id="uom-list"></tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab-2" role="tabpanel">
					<h4 class="tab-title">Another one</h4>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor tellus eget condimentum rhoncus. Aenean massa. Cum sociis natoque
						penatibus et magnis neque dis parturient montes, nascetur ridiculus mus.</p>
					<p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
						eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
				</div>
				<div class="tab-pane" id="tab-3" role="tabpanel">
					<h4 class="tab-title">One more</h4>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor tellus eget condimentum rhoncus. Aenean massa. Cum sociis natoque
						penatibus et magnis neque dis parturient montes, nascetur ridiculus mus.</p>
					<p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
						eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
				</div>
			</div>
		</div>
	</div>
</div>

@include('../lookups/uom-lookup')
@endsection


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let input_itemid = $("input[name='itemid']").val();
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
			postData('/items/getUom', {data})
		  .then(res => {
		    let td = '';
		    let ready_data = [];
		    for(let i in res) {
	    		ready_data.push([
		    		`<tr>
		    			<td>
		    				<button rowkey="${res[i].uomid}" id="row-${res[i].uomid}" class="btn btn-primary btnSaveUom"><i class="far fa-eye"></i></button>
		    				<button rowkey="${res[i].uomid}" id="row-${res[i].uomid}" class="btn btn-danger btnDeleteUom"><i class="far fa-trash-alt"></i></button>
	    				</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<span class="hide-me">${res[i].uom}</span>
		    				<input type="text" name="uom" id="uomrow-${res[i].uomid}" class="form-control" value="${res[i].uom}"">
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<input type="text" name="uom" id="costrow-${res[i].uomid}" class="form-control" value="${res[i].cost}"">
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<input type="text" name="uom" id="amtrow-${res[i].uomid}" class="form-control" value="${res[i].amt}"">
		    			</td>
		    		</tr>`,
		    	]);
		    }
		    uomtable.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		load_uom({itemid : input_itemid});

		$("#btnSave").click((e) => {
			e.preventDefault();
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
		    // }
		    // console.log(itemid);

				load_uom({itemid:data.data[0].itemid});
		  }).catch((error) => {
        console.log(error);
	    });
		}); // end #btnSave

		
		$(document).on("click", "#uom-list .btnSaveUom", (e) => {
	  	let uomid = e.currentTarget.attributes[0].nodeValue;
	  	let uom = $("#uom-list .btnSaveUom").closest('tr').find(`td:eq(1) #uomrow-${uomid}`).val();
	  	let cost = $("#uom-list .btnSaveUom").closest('tr').find(`td:eq(2) #costrow-${uomid}`).val();
	  	let amt = $("#uom-list .btnSaveUom").closest('tr').find(`td:eq(3) #amtrow-${uomid}`).val();

	  	let uom_data = {
	  		itemid : input_itemid,
	  		uomid : uomid,
				uom : uom,
				cost : cost,
				amt : amt
			}

			postData('/items/saveUom', {data: uom_data})
		  .then(res => {
				load_uom({itemid:input_itemid});
		  }).catch((error) => {
        console.log(error);
	    });
	  	// console.log(uom_data);
	  });


	});
</script>