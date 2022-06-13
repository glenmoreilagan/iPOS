<head>
	<style type="text/css">
	</style>
</head>

@extends('index')

@section('title', 'Roles')
@section('content')

<h1 class="h3 mb-3">MANAGE ROLE AND ACCESS</h1>
<div class="card mb-3">
	<div class="card-header">
		<div class="headbtns">
			<form method="POST" class="form-horizontal" role="form" action="/roles/role">
				{{ csrf_field() }}
				<button class="btn btn-primary" id="btnNew"><i data-feather="file-plus"></i> New</button>
				<button class="btn btn-primary" id="btnSave"><i data-feather="save"></i> Save</button>
				<button class="btn btn-primary" id="btnDelete"><i data-feather="trash"></i> Delete</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		@php
			// print_r($data);
			// return;
			$roleid = isset($data->roleid) ? $data->roleid : 0;
			$role = isset($data->role) ? $data->role : "";
		@endphp
		<div class="row">
			<div class="col-md-3">
				<div class="mb-3">
					<label>Role</label>
					<div class="input-group">
						<input name="roleid" type="hidden" class="form-control txtrole_infohead" id="" placeholder="Input ROLEID" value="{{ $roleid }}">
						<input name="role" type="text" class="form-control txtrole_infohead" id="" placeholder="" value="{{ $role }}">
						{{-- <span class="input-group-append">
            	<button class="btn btn-primary"  data-toggle="modal" data-target="#lookupRole" id="btnlookupRole"><i data-feather="menu"></i></button>
	          </span> --}}
					</div>
			  </div>
			</div>
		</div>

		<div class="row">
		  <div class="col-md-4 mb-4">
		  	<h5 class="card-title">MODULES LIST</h5>
		  	<ul>
		  		@foreach($parent_menus as $key => $parent)
		  			<li>
	  			  	{{-- <label class="form-check"> --}}
	  		        <input 
	  			        rowkey = "{{ $parent->parentid }}"
	  			        parentid = "{{ $parent->parentid }}"
	  		        	id="parent-checkbox-{{ $parent->parentid }}" 
	  		        	class="parent-chbox-menu form-check-input" 
	  		        	type="hidden" 
	  			        name="{{ strtolower(str_replace(" ", "_", $parent->parentname)) }}" 
	  			        value="{{ $parent->parentid }}" 
	  		        >
	  		        <span class="form-check-label">{{ $parent->parentname }}</span>
	  		      {{-- </label> --}}
		  			</li>
		  			@foreach($child_menus as $k => $child)
			  			@if($parent->parentid == $child->parentid)
				  			<ul>
						  		<li>
								  	<label class="form-check">
							        <input 
								        rowkey = "{{ $child->childid }}"
								        childid = "{{ $child->childid }}"
								        parentid = "{{ $child->parentid }}"
							        	id="child-checkbox-{{ $child->childid }}" 
							        	class="child-chbox-menu form-check-input set-check-{{ $parent->parentid }}" 
							        	type="checkbox" 
								        name="{{ strtolower(str_replace(" ", "_", $child->childname)) }}" 
								        value="{{ $child->childid }}" 
								        {{ $child->isallow }}
							        >
							        <span class="form-check-label">{{ $child->childname }}</span>
							      </label>
						  		</li>
				  			</ul>
			  			@endif
		  			@endforeach
		  		@endforeach
		  	</ul>
	  	</div>
	  </div>
	</div>
</div>
@endsection

<script type="text/javascript" src="/js/settings/roles.js"></script>