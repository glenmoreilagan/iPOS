<head>
	<style type="text/css">
		.items-div {
			/*border: 1px solid #DEDEDE;*/
			padding: 10px;
			overflow-y: scroll;
			height: 420px;
		}
		.card-div {
			/*border: 1px solid #DEDEDE;*/
		}
		.product-item {
			border-radius: 5px;
			background: #ffffff;
			box-shadow:  5px 5px 15px #d9d9d9,
			             -5px -5px 15px #ffffff;
			height: 165px;
			padding: 0px 10px 0px 10px
		}
		.product-item:hover {
			background-color: #F7F9FC;
		}
		.item-img {
	    text-align: center;
	    /*box-shadow:  5px 5px 15px #d9d9d9,
			             -5px -5px 15px #ffffff;*/
		}

		.item-info {
			text-align: center;
		}
		.default-font-size {
			/*font-weight: 600;*/
	    font-size: 10px;
		}
		.btnAddCart {
			position: absolute;
	    top: 130px;
	    width: 100px;
		}
		.div-btnaddcart {
			display: flex;
	    align-items: center;
	    justify-content: center;
		}
		.filter-item {
			/*border: 1px solid;*/
	    padding: 0.5rem 2rem;
			text-align: center;
			width: 100px;
			cursor: pointer;

			border-radius: 5px;
			background: #ffffff;
			box-shadow:  5px 5px 15px #d9d9d9,
			             -5px -5px 15px #ffffff;
		}
		.filter-item:hover {
			background-color: #F7F9FC;
		}

		.btnAddMinus {
			cursor: pointer;
			font-size: 1.3rem;
		}

		.max-width {
			width: 50%;
		}

		.min-width {
			width: 25%;
		}

		.right-text {
			text-align: right;
		}

		.center-text {
			text-align: center;
		}

		.bold-text {
			font-weight: 600;
		}

		.border-bottom {
			border-bottom: .1px solid #DEDEDE;
		}

		.cart-item-list {
			height: 20em; 
			overflow-y: scroll; 
			padding: 0px 10px 0px 0px;
		}

		.cart-itemname-td {
			padding-bottom: 5px;
		}

		.badge {
			font-size: 10px !important;
		}

	</style>
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
						<table style="width: 100%;">
							<tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br>
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									<span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td" style="width: 20%;">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>
							<table style="width: 100%;">
							<tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br>
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									<span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td" style="width: 20%;">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>
							<table style="width: 100%;">
							<tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br>
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									<span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td" style="width: 20%;">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>
							<table style="width: 100%;">
							<tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br>
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									<span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td" style="width: 20%;">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>
							<table style="width: 100%;">
							<tr class="border-bottom">
								<td class="cart-itemname-td max-width">
									<span class="default-font-size">Americano Americano<sup>12oz</sup></span>
									<br>
									<span class="default-font-size">P 75.00</span>
									<br>
									{{-- <span class="default-font-size bold-text">P 100.00</span> --}}
									<span class="badge badge-info">P 100.00</span>
								</td>
								<td class="cart-qty-td" style="width: 20%;">
									<input type="text" class="form-control form-control-sm center-text qty" value="99">
								</td>
								<td class="cart-total-td min-width center-text">
									<button class="btn btn-primary btn-sm btnviewItem"><i class="far fa-save"></i></button>
									<button class="btn btn-danger btn-sm btnDeleteUom"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>
						</table>
					</div>
					<div class="summary-bill-div">
						<table style="width: 100%;">
							<tr>
								<td class="max-width">
									<span class="default-font-size bold-text">Total Bill:</span>
								</td>
								<td class="min-width right-text">
									<span class="default-font-size bold-text" id="lbltotalbill">P 999.99</span>
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
									<span class="default-font-size bold-text" id="lbltotalcredit">P 1.00</span>
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

		$(document).on("click", ".btnAddCart", (e) => {
			let itemid = e.currentTarget.attributes[0].nodeValue;
			let uomid = e.currentTarget.attributes[1].nodeValue;;
			let amt = e.currentTarget.attributes[2].nodeValue;;

			let ready_to_cart = {
				itemid : itemid,
				uomid : uomid,
				amt : amt
			};
			console.log(ready_to_cart);
		});
	})
</script>