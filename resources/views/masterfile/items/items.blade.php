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
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode <sup id="lblitemid"></sup>
						{{-- <input name="itemid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input itemid" value="0"> --}}
						<input name="barcode" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Barcode">
					</label>
					<label>Item Name
						<input name="itemname" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Item Name">
					</label>
					<label>Default UOM
						<input name="uom" type="text" class="form-control txtitem_infohead" id="" placeholder="Input UOM" value="PCS">
					</label>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let itemid = 0;
		$("#btnSave").click((e) => {
			e.preventDefault();

			let items_info = $(".txtitem_infohead").serializeArray();
			items_info.push({name: "itemid", value: itemid});

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
		    	itemid = data.data[0].itemid;
		    	// $("input[name='itemid']").val(data.data[i].itemid);
		    	$("input[name='itemname']").val(data.data[0].itemname);
		    	$("input[name='barcode']").val(data.data[0].barcode);
		    // }
		    // console.log(itemid);
		  }).catch((error) => {
        console.log(error);
	    });
		}); // end #btnSave
	});
</script>