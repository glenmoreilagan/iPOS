<head>
	<style type="text/css">
		.txtnumber {
			width: 15px;
		}

		.isedited {
			background-color: #C7E8CE !important;
		}
	</style>
</head>
@extends('index')

@section('title', 'Inventory Setup')
@section('content')
<h1 class="h3 mb-3">INVENTORY SETUP</h1>
<div class="card mb-3">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/IS/setup">
				{{ csrf_field() }}
				<button class="btn btn-primary" id="btnNew"><i data-feather="file-plus"></i> New</button>
				<button class="btn btn-primary" id="btnSave"><i data-feather="save"></i> Save</button>
				<button class="btn btn-primary" id="btnDelete"><i data-feather="trash"></i> Delete</button>
				<button class="btn btn-primary" id="btnPost"><i data-feather="send"></i> Post</button>

			</form>
		</div>
	</div>
	<div class="card-body">
		@php
			// echo "<pre>";
			// print_r($head);
			$txid = isset($head[0]["txid"]) ? $head[0]["txid"] : 0;
			$docnum = isset($head[0]["docnum"]) ? $head[0]["docnum"] : "";
			$supplierid = isset($head[0]["supplierid"]) ? $head[0]["supplierid"] : 0;
			$supplier = isset($head[0]["supplier"]) ? $head[0]["supplier"] : '';
			$dateid = isset($head[0]["dateid"]) ? $head[0]["dateid"] : '';
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Document # <sup id="lbltxid">{{ $txid }}</sup></label>
					<div class="input-group">
						<input name="txid" type="hidden" class="form-control txtsetup_infohead" id="" placeholder="Input txid" value="{{ $txid }}">
						<input name="docnum" type="text" class="form-control txtsetup_infohead" id="" placeholder="Input Document #" value="{{ $docnum }}">
					</div>
					<label>Supplier</label>
					<div class="input-group">
						<input name="supplier" type="text" class="form-control txtsetup_infohead" id="" placeholder="Input Supplier" value="{{ $supplier }}" supplierid="{{ $supplierid }}" readonly>
						<span class="input-group-append">
            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupSupplier" id="btnlookupSupplier"><i data-feather="menu"></i></button>
	          </span>
					</div>
			  </div>
			</div>
			<div class="col-md-3">
			  <div class="mb-3">
			  	<label>Date</label>
			  	<div class="input-group">
						<input name="dateid" type="date" class="form-control txtsetup_infohead" id="" value="{{ $dateid }}">
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
		<div class="tab tab-primary stock-list-tab">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item"><a class="nav-link active" href="#tab-1" data-toggle="tab" role="tab">INVENTORY TAB</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1" role="tabpanel">
					<div class="tab-buttons-headder mb-3">
						<button class="btn btn-primary" id="btnlookupItem"><i data-feather="plus"></i> Add Item</button>
					</div>
					<table id="stock-list-table" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th style="width: 100px;">Action</th>
								<th style="width: 100px;">Barcode</th>
								<th style="width: 150px;">Itemname</th>
								<th style="width: 50px;">UOM</th>
								<th style="width: 100px;">Quantity</th>
								<th style="width: 100px;">Cost</th>
							</tr>
						</thead>
						<tbody id="stock-list"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@include('../lookups/supplier-lookup')
@include('../lookups/item-lookup')
@endsection

<script type="text/javascript" src="/js/inventory/IS.js"></script>
<script type="text/javascript" src="/js/input_validation.js"></script>