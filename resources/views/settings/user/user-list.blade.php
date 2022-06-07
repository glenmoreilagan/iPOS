@extends('../index')

@section('title', 'Users')
@section('content')
<h1 class="h3 mb-3">USERS</h1>
<div class="card">
	<div class="card-header">
		<form>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-user-info" id="btnmodal-user-info"><i data-feather="file-plus"></i> New</button>
		</form>
	</div>
	<div class="card-body">
		<table id="datatables-reponsive" class="user-list-table table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>Action</th>
				<th>Name</th>
				<th>Email</th>
				<th>Username</th>
				<th>Password</th>
				<th>Role</th>
			</tr>
		</thead>
		<tbody class="user-list"></tbody>
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
				  <div class="col-md-6 mb-4">
					  <div class="mb-3">
							<label>Name</label>
							<input type="hidden" class="form-control txt_userinfo" id="" placeholder="Input Userid" name="userid" value="0">
							<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Name" name="name">
					  </div>
					  <div class="mb-3">
							<label>Email</label>
							<input type="email" class="form-control txt_userinfo" id="" placeholder="Input Email" name="email">
					  </div>
					  {{-- <div class="mb-3">
							<label>Address</label>
							<textarea class="form-control txt_userinfo" id="" placeholder="Input Address" rows="2" name="address"></textarea>
					  </div> --}}
					</div>

					<div class="col-md-6 mb-4">
						<div class="mb-3">
							<label>Username</label>
							<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Username" name="username">
					  </div>
					  <div class="mb-3">
							<label>Password</label>
							<input type="password" class="form-control txt_userinfo" id="" placeholder="Input Password" name="password">
					  </div>
					  <div class="mb-3">
							<label>Role</label>
	  					<div class="input-group">
								<input type="hidden" class="form-control txt_userinfo" id="" placeholder="Input RoleID" name="roleid" value="0">
								<input type="text" class="form-control txt_userinfo" id="" placeholder="Input Role" name="role" readonly>
								<span class="input-group-append">
		            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupRoles" id="btnlookupRoles"><i data-feather="menu"></i></button>
			          </span>
			        </div>
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

@include('../lookups/roles-lookup')
@endsection

<script type="text/javascript" src="/js/settings/users.js"></script>