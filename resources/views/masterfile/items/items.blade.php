<head>
	<style type="text/css">
		.uom-row-class.isedited {
			background-color: #C7E8CE;
		}
	</style>
</head>

@extends('index')

@section('title', 'Items')
@section('content')

<h1 class="h3 mb-3">ITEMS</h1>
<div class="card mb-3">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/items/item">
				{{ csrf_field() }}
				<button class="btn btn-primary" id="btnNew"><i data-feather="file-plus"></i> New</button>
				<button class="btn btn-primary" id="btnSave"><i data-feather="save"></i> Save</button>
				<button class="btn btn-primary" id="btnDelete"><i data-feather="trash"></i> Delete</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		@php
			// echo "<pre>";
			// print_r($items);
			$itemid = isset($items[0]["itemid"]) ? $items[0]["itemid"] : 0;
			$itemname = isset($items[0]["itemname"]) ? $items[0]["itemname"] : '';
			$barcode = isset($items[0]["barcode"]) ? $items[0]["barcode"] : '';
			$uomid = isset($items[0]["uomid"]) ? $items[0]["uomid"] : 0;
			$uom = isset($items[0]["uom"]) ? $items[0]["uom"] : 'PCS';
			$catid = isset($items[0]["catid"]) ? $items[0]["catid"] : 0;
			$category = isset($items[0]["category"]) ? $items[0]["category"] : '';
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode <sup id="lblitemid">{{ $itemid }}</sup></label>
					<div class="input-group">
						<input name="itemid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input itemid" value="{{ $itemid }}">
						<input name="barcode" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Barcode" value="{{ $barcode }}">
					</div>
					<label>Item Name</label>
					<div class="input-group">
						<input name="itemname" type="text" class="form-control txtitem_infohead" id="" placeholder="Input Item Name" value="{{ $itemname }}">
					</div>
					<label>Default UOM</label>
					<div class="input-group">
						<input name="uomid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input UOMID" value="{{ $uomid }}">
						<input name="uom" type="text" class="form-control txtitem_infohead" id="" placeholder="Input UOM" value="{{ $uom }}">
						<span class="input-group-append">
            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupUom" id="btnlookupUom"><i data-feather="menu"></i></button>
	          </span>
					</div>
					<label>Category</label>
					<div class="input-group">
						<input name="catid" type="hidden" class="form-control txtitem_infohead" id="" placeholder="Input UOMID" value="{{ $catid }}">
						<input name="category" type="text" class="form-control txtitem_infohead" id="" placeholder="" value="{{ $category }}" readonly>
						<span class="input-group-append">
            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupCategory" id="btnlookupCategory"><i data-feather="menu"></i></button>
	          </span>
					</div>

			  </div>
			</div>
		</div>
	</div>
</div>

<div class="card mb-3">
	{{-- <div class="card-header">
	</div> --}}
	<div class="card-body">
		<div class="tab tab-primary uom-list-tab">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#tab-1" data-toggle="tab" role="tab">UOM</a></li>
				<li class="nav-item"><a class="nav-link" href="#tab-2" data-toggle="tab" role="tab">TAB1</a></li>
				<li class="nav-item"><a class="nav-link" href="#tab-3" data-toggle="tab" role="tab">TAB2</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1" role="tabpanel">
					{{-- <h4 class="tab-title">UOM</h4> --}}
					<table id="uom-list-table" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Action</th>
								<th>UOM</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody id="uom-list"></tbody>
					</table>
				</div>
				<div class="tab-pane" id="tab-2" role="tabpanel">
					<h4 class="tab-title">Another one</h4>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor tellus eget condimentum rhoncus. Aenean massa. Cum sociis natoque
						penatibus et magnis neque dis parturient montes, nascetur ridiculus mus.</p>
					<p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
						eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
				</div>
				<div class="tab-pane" id="tab-3" role="tabpanel">
					<h4 class="tab-title">One more</h4>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor tellus eget condimentum rhoncus. Aenean massa. Cum sociis natoque
						penatibus et magnis neque dis parturient montes, nascetur ridiculus mus.</p>
					<p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate
						eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.</p>
				</div>
			</div>
		</div>
	</div>
</div>

@include('../lookups/uom-lookup')
@include('../lookups/category-lookup')
@endsection

<script type="text/javascript" src="/js/masterfile/items.js"></script>