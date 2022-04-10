<head>
	<style type="text/css">
		.headbtns > button {
			width: 100px;
		}
	</style>
</head>
@extends('index')

@section('content')
<h1 class="h3 mb-3">ITEMS</h1>
<div class="card">
	<div class="card-header">
		<div class="headbtns">
			<button class="btn btn-primary">New</button>
			<button class="btn btn-primary" id="btnSave">Save</button>
			<button class="btn btn-primary">Delete</button>
		</div>
	</div>
	<div class="card-body">
		@php
			print_r($items)
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode - <sup>123</sup>
						<input name="barcode" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Barcode">
					</label>
					<label>Item Name
						<input name="itemname" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Item Name">
					</label>
					<label>Default UOM
						<input name="uom" type="text" class="form-control txtitem_infohead" id="" placeholder="Input UOM">
					</label>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		$("#btnSave").click((e) => {
			e.preventDefault();

			let items_info = $(".txtitem_infohead").serializeArray();

			let ready_data_arr = [];
			let ready_data_obj = {};
			for(i in items_info) {
				ready_data_obj[items_info[i].name] = items_info[i].value;
			}

			ready_data_arr.push(ready_data_obj);

			postData('/saveItem', {data: ready_data_arr})
		  .then(data => {
		    console.log(data);
		  });
		});


	});
</script>