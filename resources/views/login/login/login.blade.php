<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">
	<link rel="shortcut icon" href="/img/favicon.ico">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">

	<!-- BEGIN SETTINGS -->
	<!-- Remove this after purchasing -->
	<link class="js-stylesheet" href="/css/css/light.css" rel="stylesheet"/>
	<link class="js-stylesheet" href="/css/all.css" rel="stylesheet"/>
</head>
<body>
	<div class="content">
		<form method="POST" action="/login/login">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<label>username</label>
			<div class="input-group">
				<input name="username" type="text" class="form-control form-control-sm" id="" placeholder="Input username" autocomplete="off">
			</div>

			<label>password</label>
			<div class="input-group">
				<input name="password" type="text" class="form-control form-control-sm" id="" placeholder="Input password" autocomplete="off">
			</div>
			@if(session()->has('error'))
				<span class="text-danger">{{ session()->get('error') }}</span>
			@endif
			<div class="mt-3">
				<button type="submit" class="btn btn-primary btn-sm">Login</button>
			</div>
		</form>
	</div>
</body>
</html>