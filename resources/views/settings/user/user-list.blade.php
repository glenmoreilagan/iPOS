@extends('../index')

@section('title', 'Users')
@section('content')
<h1 class="h3 mb-3">USERS</h1>
<div class="card">
	<div class="card-header">
		<button class="btn btn-primary"  data-toggle="modal" data-target="#modal-user-info" id="btnmodal-user-info"><i data-feather="file-plus"></i> New</button>
		{{-- <h5 class="card-title">USER ACCESS</h5> --}}
		<!-- <h6 class="card-subtitle text-muted">Open source JavaScript jQuery plugin for a full-sized, drag & drop event calendar.</h6> -->
	</div>
	<div class="card-body">
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

<div class="modal fade" id="modal-user-info" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">USER INFO</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body m-3">
				<div class="row">
				  <div class="col-md-4 mb-4">
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
					</div>

					<div class="col-md-4">
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btnSaveUser">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection