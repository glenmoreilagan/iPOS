@extends('index')

@section('content')
<h1 class="h3 mb-3">ROLES</h1>
<div class="card">
	<div class="card-header">
	</div>
	<div class="card-body">
		<div class="row">
		  <div class="col-md-4 mb-4">
		  	<h5 class="card-title">MODULES LIST</h5>
		  	<ul>
		  		<li>
		  			<b>Masterfile</b>
		  			<ul>
		  				{{-- <li>
						  	<div class="mb-3">
									<label>User Level</label>
									<select class="form-control select2" data-toggle="select2">
							      <option value="1">Admin</option>
							      <option value="2">Cashier</option>
							    </select>
							  </div>
		  				</li> --}}
				  		<li>
						  	<label class="form-check">
					        <input class="form-check-input" type="checkbox" value="">
					        <span class="form-check-label">Items</span>
					      </label>
				  		</li>
		  			</ul>
		  		</li>
		  		<li>
		  			<b>Settings</b>
		  			<ul>
		  				<li>
					      <label class="form-check">
				          <input class="form-check-input" type="checkbox" value="">
				          <span class="form-check-label">User Access</span>
				        </label>
				  		</li>
		  			</ul>
		  		</li>
		  	</ul>
	  	</div>
	  </div>
	</div>
</div>
@endsection