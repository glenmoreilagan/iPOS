<div class="modal fade" id="lookupSupplier" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">LOOKUP SUPPLIER</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
			</div>
			<div class="modal-body m-3">
				<table id="supplier-lookup-list-table" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>Action</th>
							<th>Code</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody id="supplier-lookup-list"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", (e) => {
		// let input_clientid = $("input[name='clientid']").val();
		let supplierlookup_table = $("#supplier-lookup-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
			"ordering": false
		});

		// this function is to maximize width of the datatable in modal
		// if you encounter not filled whole width
		// https://stackoverflow.com/questions/36543622/datatables-in-bootstrap-modal-width
		$(document).on('shown.bs.modal', (e) => {
		   supplierlookup_table.columns.adjust();
		});

		const load_supplier = () => {
			postData('/suppliers/getSuppliers', {})
		  .then(res => {
		    let td = '';
		    let ready_data = [];
		    for(let i in res) {
	    		ready_data.push([
		    		`<tr>
		    			<td>
		    				<button rowkey="${res[i].clientid}" id="row-${res[i].clientid}" class="btn btn-primary btnSelectSupplier"><i class="far fa-eye"></i></button>
	    				</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<span id="supprow-${res[i].clientid}">${res[i].code}</span>
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				<span id="supprow-${res[i].clientid}">${res[i].name}</span>
		    			</td>
		    		</tr>`,
		    	]);
		    }
		    supplierlookup_table.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		$("#btnlookupSupplier").click((e) => {
	  	e.preventDefault();

	  	load_supplier();
	  });

	  $(document).on("click", "#supplier-lookup-list .btnSelectSupplier", (e) => {
	  	let clientid = e.currentTarget.attributes[0].nodeValue;
	  	let name = $("#supplier-lookup-list .btnSelectSupplier").closest('tr').find(`td:eq(2) #supprow-${clientid}`).text();

	  	$("input[name='supplierid']").val(clientid);
    	$("input[name='supplier']").val(name);
    	$("input[name='supplier']").attr('supplierid', clientid);
    	$("#lookupSupplier").modal('hide');
	  });
	});

</script>