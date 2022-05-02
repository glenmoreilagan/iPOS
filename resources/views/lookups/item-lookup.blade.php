<div class="modal fade" id="lookupItem" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">LOOKUP ITEM</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
			</div>
			<div class="modal-body m-3">
				<table id="item-lookup-list-table" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th><input type="checkbox" name="select_all_item" id="select-all-item"></th>
							{{-- <th>Action</th> --}}
							<th>Barcode</th>
							<th>Itemname</th>
						</tr>
					</thead>
					<tbody id="item-lookup-list"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnAddItemAccept">Accept</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", (e) => {
		// let input_clientid = $("input[name='clientid']").val();
		// let itemlookup_table = $("#item-lookup-list-table").DataTable({
		// 	responsive: true,
		// 	"dom": '<"top"f>rt<"bottom"ip><"clear">',
		// 	"pageLength": 50,
		// 	"scrollY" : "250px",
		// 	"scrollX" : true,
		// 	"scrollCollapse" : true,
		// 	"fixedHeader" : true,
		// 	"ordering": false
		// });

		// this function is to maximize width of the datatable in modal
		// if you encounter not filled whole width
		// https://stackoverflow.com/questions/36543622/datatables-in-bootstrap-modal-width
		// $(document).on('shown.bs.modal', (e) => {
		//    itemlookup_table.columns.adjust();
		// });

		// const load_item = () => {
		// 	postData('/IS/getItems', {})
		//   .then(res => {
		//     let td = '';
		//     let ready_data = [];
		//     for(let i in res) {
	 //    		ready_data.push([
		//     		`<tr>
		//     			<td>
		//     				<input class="lookup-item-row" type="checkbox" name="id[]" value="${res[i].itemid}">
	 //    				</td>
		//     		</tr>`,
		//     		// `<tr>
		//     		// 	<td>
		//     		// 		<button rowkey="${res[i].itemid}" id="row-${res[i].itemid}" class="btn btn-primary btnSelectItem"><i class="far fa-eye"></i></button>
	 //    			// 	</td>
		//     		// </tr>`,
		//     		`<tr>
		//     			<td>
		//     				<span id="supprow-${res[i].itemid}">${res[i].barcode}</span>
		//     			</td>
		//     		</tr>`,
		//     		`<tr>
		//     			<td>
		//     				<span id="supprow-${res[i].itemid}">${res[i].itemname}</span>
		//     			</td>
		//     		</tr>`,
		//     	]);
		//     }
		//     itemlookup_table.clear().rows.add(ready_data).draw();
		//   }).catch((error) => {
		//     console.log(error);
		//   });
		// }

		// // Handle click on "Select all" control
		// $('#select-all-item').on('click', function() {
		//    // Get all rows with search applied
		//    var rows = itemlookup_table.rows({ 'search': 'applied' }).nodes();
		//    // Check/uncheck checkboxes for all rows in the table
		//    $('input[type="checkbox"]', rows).prop('checked', this.checked);
		// });

		// let checkedItemId = [];
		// $("#btnAddItemAccept").on("click", function() {
		// 	// Iterate over all checkboxes in the table
		//   itemlookup_table.$('.lookup-item-row').each(function() {
	 //      // If checkbox doesn't exist in DOM
	 //      // if(!$.contains(document, this)){
	 //        // If checkbox is checked
  //        	if(this.checked) {
  //        		checkedItemId.push(this.value);
  //        	}
		//     // }
		//   });

		//   console.log(checkedItemId);
		// });

		// $("#btnlookupItem").click((e) => {
	 //  	e.preventDefault();

	 //  	load_item();
	 //  });

	 //  $(document).on("click", "#item-lookup-list .btnSelectItem", (e) => {
	 //  	let clientid = e.currentTarget.attributes[0].nodeValue;
	 //  	let name = $("#item-lookup-list .btnSelectItem").closest('tr').find(`td:eq(2) #supprow-${clientid}`).text();

	 //  	$("input[name='supplierid']").val(clientid);
  //   	$("input[name='supplier']").val(name);
  //   	$("input[name='supplier']").attr('supplierid', clientid);
  //   	$("#lookupSupplier").modal('hide');
	 //  });
	});

</script>