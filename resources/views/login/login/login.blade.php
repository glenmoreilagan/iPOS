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
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<style type="text/css">
		body {
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
		.main-div-login {
			display: flex;
			justify-content: center;
		}
		.login-div {
			display: flex;
			justify-content: center;
			/*gap: 1em;*/
			background: #fff;
			box-shadow: 0 0 0.875rem 0 rgb(41 48 66 / 5%);
			border-radius: 1em;
		}

		.child-img-div {
			padding: 2em 0em 0em 0em;
			/*border: 1px solid;*/
			width: 30em;
			height: 350px;
			/*background: #fff;*/
			/*border-radius: 1em;*/
	    /*box-shadow: 0 0 0.875rem 0 rgb(41 48 66 / 5%);*/
		}

		.child-login-div {
			padding: 2em 5em 0em 0em;
			/*border: 1px solid;*/
			width: 30em;
			height: 350px;
			/*background: #fff;*/
			/*border-radius: 1em;*/
	    /*box-shadow: 0 0 0.875rem 0 rgb(41 48 66 / 5%);*/
		}

		.login-img {
			width: 100%;
	    height: 100%;
		}

		.action-buttons {
			/*position: absolute;*/
			/*top: 15em;*/
		}

		.btnLogin {
			width: 100px;
		}
	</style>
</head>
<body>
	<div class="content">
		{{-- <form method="POST" action="/login/login"> --}}
			<div class="main-div-login">
				<div class="login-div mt-6">
					<div class="child-img-div">
						<img class="login-img" src="/img/login-img.svg" width="100%;">
					</div>
					<div class="child-login-div">
						<div class="company-name-div text-center">
							<h4 style="text-transform: uppercase;">PASTPODS</h4>
						</div>
						<h6>SIGN IN</h6>
						<div class="mt-3">
							<label>Username</label>
							<div class="input-group">
								<input name="username" type="text" class="form-control form-control-sm" id="" placeholder="Input username" autocomplete="off">
							</div>

							<label>Password</label>
							<div class="input-group">
								<input name="password" type="password" class="form-control form-control-sm" id="" placeholder="Input password" autocomplete="off">
							</div>
							<span class="text-danger lblerror"></span>
							<div class="mt-3 action-buttons">
								<button class="btn btn-primary btn-sm btnLogin">Login</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		{{-- </form> --}}
	</div>
	{{-- <div style="margin-top: -40px;">
		<img src="/img/wave2.svg">
	</div> --}}
</body>
</html>


<script src="/plugins/nprogress/nprogress.js"></script>
{{-- https://www.uglifyjs.net/ --}}
<script type="text/javascript" src="/js/post_request.js"></script>
<script src="/js/js/app.js"></script>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {
		// const postData = async (url = '', data = {}) => {
		//   const response = await fetch(url, {
		//     method: 'POST',
		//     mode: 'cors',
		//     cache: 'no-cache',
		//     credentials: 'same-origin',
		//     headers: {
		//       'Content-Type': 'application/json',
		//       'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
		//       // 'GLEN-KEY' : getCookie('GLEN-KEY')
		//     },
		//     redirect: 'follow',
		//     referrerPolicy: 'no-referrer',
		//     body: JSON.stringify(data)
		//   });
		//   return response.json();
		// }

		$(".btnLogin").click((e) => {
			e.preventDefault();

			postData('/login/login', {
				"username" : $("input[name='username']").val(),
				"password" : $("input[name='password']").val()
			})
		  .then(res => {
		  	console.log(res);
		  	if (res.status) {
		  		$(".lblerror").text(res.msg);
			    window.location = `${res.path}`;
		  	} else {
		  		$(".lblerror").text(res.msg);
		  	}
		  }).catch((error) => {
		    console.log(error);
		  });
		});
	});
</script>