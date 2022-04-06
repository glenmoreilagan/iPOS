@extends('index')

@section('content')
<h1 class="h3 mb-3">ITEMS</h1>
<div class="card">
	<div class="card-header">
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Barcode - <sup>123</sup>
						<input type="text" class="form-control" id="" placeholder="Input Barcode">
					</label>
					<label>Item Name
						<input type="text" class="form-control" id="" placeholder="Input Item Name">
					</label>
					<label>UOM
						<input type="text" class="form-control" id="" placeholder="Input UOM">
					</label>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection