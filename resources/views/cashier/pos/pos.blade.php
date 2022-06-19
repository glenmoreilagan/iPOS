<head>
	<link class="js-stylesheet" href="/css/pos.css" rel="stylesheet"/>
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
<script type="text/javascript" src="/js/cashier/pos.js"></script>
<script type="text/javascript" src="/js/input_validation.js"></script>