@extends('../index')

@section('content')
<h1 class="h3 mb-3">USER ACCESS</h1>
<div class="card">
	<div class="card-header">
		{{-- <h5 class="card-title">USER ACCESS</h5> --}}
		<!-- <h6 class="card-subtitle text-muted">Open source JavaScript jQuery plugin for a full-sized, drag & drop event calendar.</h6> -->
	</div>
	<div class="card-body">
		<div class="row">
		  <div class="col-md-4 mb-4">
		  	<h5 class="card-title">MODULES LIST</h5>
		  	<ul>
		  		<li>
		  			<b>Masterfile</b>
		  			<ul>
		  				<li>
						  	<div class="mb-3">
									<label>User Level</label>
									<select class="form-control select2" data-toggle="select2">
							      <option value="1">Admin</option>
							      <option value="2">Cashier</option>
							    </select>
							  </div>
		  				</li>
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
	  	<div class="col-md-8">
		  	{{--  --}}
			</div>

		  <div class="col-md-4 mb-4">
		  	<h5 class="card-title">USER INFO</h5>
			  <div class="mb-3">
					<label>Name</label>
					<input type="text" class="form-control" id="" placeholder="Input Name">
			  </div>
			  <div class="mb-3">
					<label>Address</label>
					<textarea class="form-control" id="" placeholder="Input Address" rows="2"></textarea>
			  </div>
			  <div class="mb-3">
					<label>Email</label>
					<input type="email" class="form-control" id="" placeholder="Input Email">
			  </div>
			  <div class="mb-3">
			  	<button class="btn btn-primary"><i class="far fa-save"></i> Save</button>
			  </div>
			</div>

			<div class="col-md-4">
				<h5 class="card-title">&nbsp;</h5>
				<div class="mb-3">
					<label>Username</label>
					<input type="text" class="form-control" id="" placeholder="Input Username">
			  </div>
			  <div class="mb-3">
					<label>Password</label>
					<input type="password" class="form-control" id="" placeholder="Input Password">
			  </div>
			</div>
		</div>

		<table id="datatables-reponsive" class="table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Position</th>
				<th>Office</th>
				<th>Age</th>
				<th>Start date</th>
				<th>Salary</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><button class="btn btn-primary btn-sm"><i class="far fa-eye"></i></button></td>
				<td>System Architect</td>
				<td>Edinburgh</td>
				<td>61</td>
				<td>2011/04/25</td>
				<td>$320,800</td>
			</tr>
			<tr>
				<td>Garrett Winters</td>
				<td>Accountant</td>
				<td>Tokyo</td>
				<td>63</td>
				<td>2011/07/25</td>
				<td>$170,750</td>
			</tr>
			<tr>
				<td>Ashton Cox</td>
				<td>Junior Technical Author</td>
				<td>San Francisco</td>
				<td>66</td>
				<td>2009/01/12</td>
				<td>$86,000</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>
@endsection