@extends('../index')

@section('content')
<h1 class="h3 mb-3">ITEMS</h1>
<div class="card">
	<div class="card-header">
		<form method="POST" class="form-horizontal" role="form" action="{{ route('new.item') }}">
			{{ csrf_field() }}
			<button class="btn btn-primary"><i class="far fa-save"></i> New</button>
		</form>
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
@endsection