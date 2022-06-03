<head>
	<link class="js-stylesheet" href="/css/pos.css" rel="stylesheet"/>
	<style type="text/css">
		.table-cart-list .txtrow-cart-qty.isedited {
			background-color: #C7E8CE;
		}
	</style>
</head>

@extends('index')

@section('title', 'POS')
@section('content')
<h1 class="h3 mb-3">POINT OF SALE</h1>
<div class="card">
{{-- 	<div class="card-header">
	</div> --}}
	<div class="card-body">
		<div class="row">
			<div class="col-md-8 items-div">
				<div class="filtering-div mb-3">
					<span data-filter class="filter-item">ALL</i></span>
					@foreach($category as $key => $cat)
						<span data-filter="{{ $cat->category }}" class="filter-item">{{ $cat->category }}</span>
					@endforeach
				</div>
				<div class="row">
					@foreach($items as $key => $item)
						<div data-tags="{{ $item->category }}" class="col-md-3 mb-3 main-wrapper-product-div">
							<div class="product-item">
								{{-- <div class="div-lblitembal">
									<span class="lblitembal-{{ $item->itemid }} default-font-size right-text">{{ $item->bal }}</span>
								</div> --}}
								<div class="item-img">
									<img class="mt-3" src="/img/favicon.ico">
								</div>
								<div class="item-info mt-3">
									<span class="default-font-size">{{ $item->itemname }}<sup>{{ $item->uom }}</sup></span>
									<br>
									<span class="default-font-size">₱{{ $item->amt }}</span>
								</div>
								<div class="div-btnaddcart mt-3">
									<button 
										itemid="{{ $item->itemid }}" 
										uomid="{{ $item->uomid }}" 
										amt="{{ $item->amt }}" 
										bal="{{ $item->bal }}" 
										class="btnAddCart btn btn-primary btn-sm" 
										id="item-row-{{ $item->itemid }}">
										ADD
								</button>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="col-md-4">
				<div class="card-div">
					<h3>CART <i data-feather="shopping-cart"></i></h3>
					<div class="cart-item-list mb-3">
						<table class="table-cart-list" style="width: 100%;"></table>
					</div>
					<div class="summary-bill-div">
						<table style="width: 100%;">
							<tr>
								<td class="max-width">
									<span class="default-font-size bold-text">Total Bill:</span>
								</td>
								<td class="min-width right-text">
									<span class="default-font-size bold-text" id="lbltotalbill"></span>
								</td>
							</tr>
							<tr>
								<td class="max-width">
									<span class="default-font-size bold-text">Cash:</span>
								</td>
								<td class="min-width right-text">
									<input type="text" class="form-control right-text" id="txtcash">
								</td>
							</tr>
							<tr>
								<td class="max-width">
									<span class="default-font-size bold-text">Change:</span>
								</td>
								<td class="min-width right-text">
									<span class="default-font-size bold-text" id="lbltotalchange"></span>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: center;">
									<button class="btn btn-primary btn-sm max-width btn-checkout">CHECKOUT</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		$.autofilter({
			// CSS class when shown
			showClass: 'show',

			// use HTML as filter string
			htmlAsFilter: false,

			// filter string as substring
			subString: false,

			// minimum characters to start filter in input mode
			minChars: 3,

			// is case sensitive?
			caseSensitive: false,

			// enable animation
			animation: true,

			// duration in ms
			duration: 300
		});
		let GLOBAL_TXID = 0;
		const debounce = (func, wait, immediate) => {
	    var timeout;
	    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
	    };
		};
		const BASE_OBJ = {
			totalbill : 0,
			ADD_TO_CART : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
			  		BASE_OBJ.totalbill = 0;
				  	BASE_OBJ.LOADCART('/POS/loadCart', {data: {}});
			  	}
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			LOADCART : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if(res.status) {
			  		let txid = res.data.length > 0 ? res.data[0].txid : 0;
				  		// $("#lbltxid").text(txid);
				  		GLOBAL_TXID = txid;
			  		// console.log(res);
				  	BASE_OBJ.DISPLAY_CART(res.data)
			  	}
					// notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			DISPLAY_CART : (data) => {
				let str = '';
				for(let i in data) {
					counter = parseInt(i) + 1;

					let line = data[i].line;
					let itemid = data[i].itemid;
					let itemname = data[i].itemname;
					let uom = data[i].uom;
					let uomid = data[i].uomid;
					let amt = data[i].amt;
					let qty = data[i].qty;
					let total = data[i].total;
					str += `
						<tr class="cart-row-${line} border-bottom">
							<td class="cart-itemname-td max-width">
								<span class="default-font-size">${counter}. ${itemname}<sup>${uom}</sup></span>
								<br>
								<span class="default-font-size">${formatter.format(amt)}</span>
								<br>
								<span class="badge badge-info">${formatter.format(total)}</span>
							</td>
							<td class="cart-qty-td">
								<input 
									id="cart-row-${line}"
									class="cart-row-${line} form-control form-control-sm center-text qty txtrow-cart-qty" 
									type="text" 
									value="${qty}" 
									itemid="${itemid}" 
									amt="${amt}" 
									line="${line}" 
									uomid="${uomid}" 
								>
							</td>
							<td class="cart-total-td min-width center-text">
								<button rowkey="${line}" id="${line}" class="action-btn-row-${line} btn-action btn btn-primary btn-sm btnSave">
									<i class="far fa-save"></i>
								</button>
								<button rowkey="${line}" id="${line}" class="action-btn-row-${line} btn-action btn btn-danger btn-sm btnDelete">
									<i class="far fa-trash-alt"></i>
								</button>
							</td>
						</tr>`;

					BASE_OBJ.totalbill += parseFloat(data[i].total);
				}
				$(".table-cart-list").html(str);
				BASE_OBJ.DISPLAY_TOTAL_BILL(BASE_OBJ.totalbill);
			},
			DISPLAY_TOTAL_BILL : (total) => {
				
				$("#lbltotalbill").text(formatter.format(total));
			},
			COMPUTE_CHANGE : (cash) => {
				let change = parseFloat(cash | 0) - BASE_OBJ.totalbill;
				change = (change > 0) ? formatter.format(change) : "";
				$("#lbltotalchange").text(change);
			},
			SAVECART : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
			  		BASE_OBJ.totalbill = 0;
				  	BASE_OBJ.LOADCART('/POS/loadCart', {data: {}});
			  	}
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			DELETECART : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
			  		BASE_OBJ.totalbill = 0;
				  	BASE_OBJ.LOADCART('/POS/loadCart', {data: {}});
			  	}
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			},
			CHECKOUT : (url, data) => {
				postData(url, data)
			  .then(res => {
			  	if (res.status) {
			  		BASE_OBJ.totalbill = 0;
				  	BASE_OBJ.LOADCART('/POS/loadCart', {data: {}});
			  	}
					notify({status : res.status, message : res.msg});
			  }).catch((error) => {
	        console.log(error);
		    });
			}
		};
		
		BASE_OBJ.LOADCART('/POS/loadCart', {data:{}});

		$(document).on("click", ".btnAddCart", debounce((e) => {
			let btnobj = $(this);
			const url = '/POS/saveCart';
			let itemid = btnobj[0].activeElement.attributes[0].nodeValue;
			// let itemid = e.currentTarget.attributes[0].nodeValue;
			let btnAdd = $(".product-item").find(`.div-btnaddcart #item-row-${itemid}`);
			let uomid = btnAdd.attr('uomid');
			let amt = btnAdd.attr('amt');
			let bal = btnAdd.attr('bal');
			let new_bal = 0;
			let txid = parseFloat(GLOBAL_TXID);

			if (parseFloat(bal) == 0) {
				notify({status : false, message : "No Available Balance!"});
				return;
			}

			let ready_to_cart_arr = [];
			let ready_to_cart_obj = {
				itemid : itemid,
				uomid : uomid,
				amt : amt
			};

			ready_to_cart_arr.push(ready_to_cart_obj);
			BASE_OBJ.ADD_TO_CART(url, {data: ready_to_cart_arr, txid : txid, line : 0});

			new_bal = bal - 1;
			btnAdd.attr('bal', new_bal);
			// $(`.lblitembal-${itemid}`).text(new_bal);
		}, 300));

		$(document).on("keyup", "#txtcash", (e) => {
			BASE_OBJ.COMPUTE_CHANGE($("#txtcash").val());
		});

		$(document).on("click", ".table-cart-list .btnSave", (e) => {
			const url = '/POS/saveCart';
			// let attr_name = e.currentTarget.attributes[0].nodeName;
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			let qty = $(".table-cart-list .btnSave").closest('tr').find(`td:eq(1) .cart-row-${rowkey}`);
			let itemid = qty.attr('itemid');
			let amt = qty.attr('amt');
			let line = qty.attr('line');
			let uomid = qty.attr('uomid');
			let txid = parseFloat(GLOBAL_TXID);
			// let bal = qty.attr("bal");

			let ready_to_cart_arr = [];
			let ready_to_cart_obj = {
				line 	 : rowkey,
				qty 	 : qty.val(),
				itemid : itemid,
				amt 	 : amt,
				line 	 : line,
				uomid 	 : uomid,
			}

			ready_to_cart_arr.push(ready_to_cart_obj);
			BASE_OBJ.SAVECART(url, {data: ready_to_cart_arr, txid: txid});
		});

		$(document).on("click", ".table-cart-list .btnDelete", (e) => {
			const url = '/POS/deleteCart';
			// let attr_name = e.currentTarget.attributes[0].nodeName;
			let rowkey = e.currentTarget.attributes[0].nodeValue;
			let qty = $(".table-cart-list .btnDelete").closest('tr').find(`td:eq(1) .cart-row-${rowkey}`);
			let itemid = qty.attr('itemid');
			let amt = qty.attr('amt');
			// let bal = qty.attr("bal");

			let ready_to_cart_arr = [];
			let ready_to_cart_obj = {
				line 	 : rowkey,
				qty 	 : qty.val(),
				itemid : itemid,
				amt 	 : amt
			}

			ready_to_cart_arr.push(ready_to_cart_obj);
			BASE_OBJ.DELETECART(url, {data: ready_to_cart_arr, line: rowkey});
		});

		$(document).on("change", ".table-cart-list .txtrow-cart-qty", (e) => {
			let row = e.currentTarget.id;

			$(`.${row}`).addClass('isedited');
		});

		$(document).on("click", ".btn-checkout", debounce((e) => {
			const url = '/POS/checkOut';
			BASE_OBJ.CHECKOUT(url, {data: {}, txid : GLOBAL_TXID});
		}, 300));
		
	});
</script>