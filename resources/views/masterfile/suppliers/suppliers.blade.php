<head>
	<style type="text/css">
	</style>
</head>
@extends('index')

@section('title', 'Suppliers')
@section('content')
<h1 class="h3 mb-3">SUPPLIERS</h1>
<div class="card mb-3">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/suppliers/supplier">
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
			// print_r($supplier);
			$clientid = isset($supplier[0]["clientid"]) ? $supplier[0]["clientid"] : 0;
			$code = isset($supplier[0]["code"]) ? $supplier[0]["code"] : '';
			$name = isset($supplier[0]["name"]) ? $supplier[0]["name"] : '';
			$address = isset($supplier[0]["address"]) ? $supplier[0]["address"] : '';
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Supplier Code <sup id="lblclientid">{{ $clientid }}</sup></label>
					<div class="input-group">
						<input name="clientid" type="hidden" class="form-control txtsupplier_infohead" id="" placeholder="Input clientid" value="{{ $clientid }}">
						<input name="code" type="text" class="form-control txtsupplier_infohead" id="" placeholder="Input Supplier Code" value="{{ $code }}">
					</div>
					<label>Supplier Name</label>
					<div class="input-group">
						<input name="name" type="text" class="form-control txtsupplier_infohead" id="" placeholder="Input Supplier Name" value="{{ $name }}">
					</div>
					<label>Address</label>
					<div class="input-group">
						<textarea name="address" class="form-control txtsupplier_infohead" id="" rows="3" placeholder="Input Address">{{ $address }}</textarea>
					</div>

			  </div>
			</div>
		</div>
	</div>
</div>
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
</script>