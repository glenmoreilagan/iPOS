<div class="modal fade" id="lookupUom" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">LOOKUP UOM</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
			</div>
			<div class="modal-body m-3">
				<table id="uom-lookup-list-table" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>Action</th>
							<th>UOM</th>
							<th>Cost</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody id="uom-lookup-list"></tbody>
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
		let input_itemid = $("input[name='itemid']").val();
		var uomlookup_table = $("#uom-lookup-list-table").DataTable({
			responsive: true,
			"dom": '<"top"f>rt<"bottom"ip><"clear">',
			"pageLength": 10,
			"scrollY" : "250px",
			"scrollX" : true,
			"scrollCollapse" : true,
			"fixedHeader" : true,
		});

		// this function is to maximize width of the datatable in modal
		// if you encounter not filled whole width
		// https://stackoverflow.com/questions/36543622/datatables-in-bootstrap-modal-width
		$(document).on('shown.bs.modal', (e) => {
		   uomlookup_table.columns.adjust();
		});

		const load_uom = (data, type='') => {
			postData('/items/getUom', {data})
		  .then(res => {
		    let td = '';
		    let ready_data = [];
		    for(let i in res) {
	    		ready_data.push([
		    		`<tr>
		    			<td>
		    				<button rowkey="${res[i].uomid}" id="row-${res[i].uomid}" class="btn btn-primary btnSelectUom"><i class="far fa-eye"></i></button>
	    				</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				${res[i].uom}
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				${res[i].cost}
		    			</td>
		    		</tr>`,
		    		`<tr>
		    			<td>
		    				${res[i].amt}
		    			</td>
		    		</tr>`,
		    	]);
		    }
		    uomlookup_table.clear().rows.add(ready_data).draw();
		  }).catch((error) => {
		    console.log(error);
		  });
		}

		$("#btnlookupUom").click((e) => {
	  	e.preventDefault();

	  	load_uom({itemid : input_itemid}, 'lookup-uom');
	  });

	});

</script>