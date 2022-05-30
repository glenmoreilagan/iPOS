@extends('index')

@section('title', 'Category')
@section('content')
<h1 class="h3 mb-3">CATEGORY</h1>
<div class="card">
	<div class="card-header">
		<form>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-category" id="btnmodal-category"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="category-list-table" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody id="item-list"></tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">CATEGORY</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body m-3">
				<div class="row">
				  <div class="col-md-12 mb-4">
					  <div class="mb-3">
							<label>Category</label>
							<input type="hidden" class="form-control txt_category" id="" placeholder="Input Catid" name="catid" value="0">
							<input type="text" class="form-control txt_category" id="" placeholder="Input Name" name="category">
					  </div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSaveCategory">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		let table = $("#category-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		const CATEGORY_OBJ = {
			LOAD_CATEGORY : () => {
				postData("/category/getCategory", {data : {}})
			  .then(data => {
			    let td = '';
			    let ready_data = [];
			    for(let i in data) {
			    	ready_data.push([
			    		`<tr>
			    			<td>
			    				<button 
			    				rowkey="${data[i].catid}" 
			    				id="row-${data[i].catid}" 
			    				class="btn-action btn btn-primary btn-sm btnviewCategory"
			    				data-toggle="modal" data-target="#modal-category">
			    					<i class="far fa-eye"></i>
			    				</button>
		    				</td>
			    		</tr>`,
			    		data[i].category
			    	]);
			    }
			    table.clear().rows.add(ready_data).draw();
			  }).catch((error) => {
			    console.log(error);
			  });
			},
			EDIT_CATEGORY : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	// console.log(res);
			  	$("input[name='catid']").val(res[0].catid);
			  	$("input[name='category']").val(res[0].category);
			  }).catch((error) => {
			    console.log(error);
			  });
			},
			SAVE_CATEGORY : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
			  		CATEGORY_OBJ.LOAD_CATEGORY();
			  	}
			  	notify({status : res.status, message : res.msg});
			  }).catch((error) => {
			    console.log(error);
			  });
			}
		}

		CATEGORY_OBJ.LOAD_CATEGORY();

		$("#btnmodal-category").click((e) => {
			e.preventDefault();
			
			$(".txt_userinfo").val('');
			$("input[name='userid']").val(0);
		});

		$(document).on("click", "#btnSaveCategory", (e) => {
			const url = "/category/setCategory";
			let user_info = $(".txt_category").serializeArray();

			let ready_data_arr = [];
			let ready_data_obj = {};
			for(i in user_info) {
				ready_data_obj[user_info[i].name] = user_info[i].value;
			}
			ready_data_arr.push(ready_data_obj);

			CATEGORY_OBJ.SAVE_CATEGORY(url, {data : ready_data_arr});
		});

		$(document).on("click", ".btnviewCategory", (e) => {
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			CATEGORY_OBJ.EDIT_CATEGORY("/category/getCategory", {data : {catid : rowkey}});
		});
	})
</script>