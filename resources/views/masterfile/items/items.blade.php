<head>
	<style type="text/css">
		.headbtns > button {
			width: 100px;
		}
		.tab-primary .tab-content, .tab-title {
			background: #ffffff !important;
    	color: #6c757d !important;
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
				<button class="btn btn-primary"><i class="far fa-save"></i> New</button>
				<button class="btn btn-primary" id="btnSave">Save</button>
				<button class="btn btn-primary">Delete</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		@php
			// print_r($items);
			$itemid = isset($items[0]["itemid"]) ? $items[0]["itemid"] : 0;
			$itemname = isset($items[0]["itemname"]) ? $items[0]["itemname"] : '';
			$barcode = isset($items[0]["barcode"]) ? $items[0]["barcode"] : '';
			$uomid = isset($items[0]["uomid"]) ? $items[0]["uomid"] : 0;
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode <sup id="lblitemid">{{ $itemid }}</sup>
						<input name="itemid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input itemid" value="{{ $itemid }}">
						<input name="barcode" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Barcode" value="{{ $barcode }}">
					</label>
					<label>Item Name
						<input name="itemname" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Item Name" value="{{ $itemname }}">
					</label>
					<label>Default UOM
						<input name="uom" type="text" class="form-control txtitem_infohead" id="" placeholder="Input UOM" value="{{ $uomid }}">
					</label>
			  </div>
			</div>
		</div>

		<div class="tab tab-primary">
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
@endsection


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		var table = $("#uom-list-table, newtable").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		const load_uom = (data) => {
			postData('/items/getUom', {data})
		  .then(data => {
		    // console.log(data);
		    let td = '';
		    let ready_data = [];
		    for(let i in data) {
		    	ready_data.push([
		    		`<tr>
		    			<td>
		    				<button rowkey="${data[i].uomid}" id="row-${data[i].uomid}" class="btn btn-primary btnSaveUom"><i class="far fa-eye"></i></button>
		    				<button rowkey="${data[i].uomid}" id="row-${data[i].uomid}" class="btn btn-danger btnDeleteUom"><i class="far fa-trash-alt"></i></button>
	    				</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<input type="text" name="uom" id="uomrow-${data[i].uomid}" class="form-control" value="${data[i].uom}"">
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<input type="text" name="uom" id="costrow-${data[i].uomid}" class="form-control" value="${data[i].cost}"">
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<input type="text" name="uom" id="amtrow-${data[i].uomid}" class="form-control" value="${data[i].amt}"">
		    			</td>
		    		</tr>`,
		    	]);
		    }
		    table.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		load_uom({itemid: $("input[name='itemid']").val()});

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
	  		uomid : uomid,
				uom : uom,
				cost : cost,
				amt : amt
			}
	  	console.log(uom_data);
	  });
	});
</script>