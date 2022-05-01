<head>
	<style type="text/css">
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
		<div class="tab tab-primary uom-list-tab">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#tab-1" data-toggle="tab" role="tab">STOCK</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1" role="tabpanel">
					{{-- <h4 class="tab-title">UOM</h4> --}}
					<table id="uom-list-table" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Action</th>
								<th>Barcode</th>
								<th>Itemname</th>
								<th>UOM</th>
								<th>Quantity</th>
								<th>Cost</th>
							</tr>
						</thead>
						<tbody id="uom-list"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('../lookups/supplier-lookup')
@endsection

<script type="text/javascript">
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
		    	$("#lbltxid").text(data.data[0].clientid);
		    	$("input[name='txid']").val(data.data[0].txid);
		    	$("input[name='docnum']").val(data.data[0].docnum);
		    	$("input[name='supplier']").attr('supplierid', data.data[0].clientid);
		    	$("input[name='supplier']").val(data.data[0].supplier);
		    // }
		    // console.log(clientid);
				notify({status : data.status, message : data.msg})
		    // window.location = `/suppliers/supplier/${data.data[0].clientid}`;
		  }).catch((error) => {
        console.log(error);
	    });
		}); // end #btnSave

	});
</script>