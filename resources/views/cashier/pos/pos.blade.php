<head>
	<link class="js-stylesheet" href="/css/pos.css" rel="stylesheet"/>
</head>

@extends('index')

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
					<span data-filter="coffee" class="filter-item">COFFEE</span>
					<span data-filter="frappe" class="filter-item">FRAPPE</span>
					<span data-filter="cookies" class="filter-item">COOKIES</span>
				</div>
				<div class="row">
					@foreach($items as $key => $item)
						<div data-tags="{{ $item->category }}" class="col-md-3 mb-3">
							<div class="product-item">
								<div class="item-img">
									<img class="mt-3" src="/img/favicon.ico">
								</div>
								<div class="item-info mt-3">
									<span class="default-font-size">{{ $item->itemname }}<sup>{{ $item->uom }}</sup></span>
									<br>
									<span class="default-font-size">₱ {{ $item->amt }}</span>
								</div>
								<div class="div-btnaddcart mt-3">
									<button 
										itemid="{{ $item->itemid }}" 
										uomid="{{ $item->uomid }}" 
										amt="{{ $item->amt }}" 
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
						<table class="table-cart-list" style="width: 100%;">
							{{-- <tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br> --}}
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									{{-- <span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn-action btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn-action btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr> --}}
						</table>
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
									<button class="btn btn-primary btn-sm max-width">CHECKOUT</button>
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
					str += `
						<tr class="border-bottom">
							<td class="cart-itemname-td max-width">
								<span class="default-font-size">${counter}. ${data[i].itemname}<sup>${data[i].uom}</sup></span>
								<br>
								<span class="default-font-size">₱ ${data[i].amt}</span>
								<br>
								<span class="badge badge-info">₱ ${data[i].total}</span>
							</td>
							<td class="cart-qty-td">
								<input type="text" class="form-control form-control-sm center-text qty" value="${data[i].qty}">
							</td>
							<td class="cart-total-td min-width center-text">
								<button class="btn-action btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
								<button class="btn-action btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
							</td>
						</tr>
					`;

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
			}
		};
		
		BASE_OBJ.LOADCART('/POS/loadCart', {data:{}});

		$(document).on("click", ".btnAddCart", (e) => {
			const url = '/POS/addCart';
			let itemid = e.currentTarget.attributes[0].nodeValue;
			let uomid = e.currentTarget.attributes[1].nodeValue;;
			let amt = e.currentTarget.attributes[2].nodeValue;;

			let ready_to_cart_arr = [];
			let ready_to_cart_obj = {
				itemid : itemid,
				uomid : uomid,
				amt : amt
			};

			ready_to_cart_arr.push(ready_to_cart_obj);
			BASE_OBJ.ADD_TO_CART(url, {data: ready_to_cart_arr});
			
		});

		$(document).on("keyup", "#txtcash", (e) => {
			BASE_OBJ.COMPUTE_CHANGE($("#txtcash").val());
		});
		
	});
</script>