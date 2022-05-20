<!DOCTYPE html>
<html lang="en">

{{-- FOR ICONS --}}
{{-- https://feathericons.com/?query=auth --}}


<!-- Mirrored from appstack.bootlab.io/calendar.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Jan 2021 13:06:37 GMT -->
<!-- Added by HTTrack -->
{{-- <meta http-equiv="content-type" content="text/html;charset=UTF-8" /> --}}
<!-- /Added by HTTrack -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title>@yield('title')</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- <link rel="canonical" href="calendar.html" /> -->
	<link rel="shortcut icon" href="/img/favicon.ico">

	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&amp;display=swap" rel="stylesheet">

	<!-- Choose your prefered color scheme -->
	<!-- <link href="css/light.css" rel="stylesheet"> -->
	<!-- <link href="css/dark.css" rel="stylesheet"> -->

	<!-- BEGIN SETTINGS -->
	<!-- Remove this after purchasing -->
	<link class="js-stylesheet" href="/css/css/light.css" rel="stylesheet"/>
	<link class="js-stylesheet" href="/css/datatable-customize.css" rel="stylesheet"/>
	<link class="js-stylesheet" href="/css/all.css" rel="stylesheet"/>
	<link class="js-stylesheet" href="/plugins/nprogress/nprogress.css" rel="stylesheet"/>
	<style type="text/css">
		body[data-theme=light] .sidebar-brand svg {
		  fill: #fff !important;
		}
		body[data-theme=light] .sidebar-brand svg path:first-child {
     	fill: #fff !important; 
		}
	</style>
	<!-- END SETTINGS -->
{{-- <script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2120269,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script> --}}
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q3ZYEKLQ68"></script> --}}
{{-- <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q3ZYEKLQ68');
</script> --}}

<script type="text/javascript">
	const getCookie = (cname) => {
	  let name = cname + "=";
	  let ca = document.cookie.split(';');
	  for(let i = 0; i < ca.length; i++) {
	    let c = ca[i];
	    while (c.charAt(0) == ' ') {
	      c = c.substring(1);
	    }
	    if (c.indexOf(name) == 0) {
	      return c.substring(name.length, c.length);
	    }
	  }
	  return "";
	}

	const postData = async (url = '', data = {}) => {
		NProgress.start();
	  const response = await fetch(url, {
	    method: 'POST',
	    mode: 'cors',
	    cache: 'no-cache',
	    credentials: 'same-origin',
	    headers: {
	      'Content-Type': 'application/json',
	      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	      // 'GLEN-KEY' : getCookie('GLEN-KEY')
	    },
	    redirect: 'follow',
	    referrerPolicy: 'no-referrer',
	    body: JSON.stringify(data)
	  });
	  NProgress.done();
	  return response.json();
	}

	const notify = (data) => {
		var message = data.message
		var type = "success"; // success or danger
		if(data.status === false) type = "danger";
		var duration = 2500;
		var ripple = false;
		var dismissible = true;
		var positionX = "left";
		var positionY = "top";
		window.notyf.open({
			type, message, duration, ripple, dismissible,
			position: { x: positionX, y: positionY }
		});
	}

	const formatter = new Intl.NumberFormat('en-US', {
	  style: 'currency',
	  currency: 'PHP',

	  // These options are needed to round to whole numbers if that's what you want.
	  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
	  //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
	});
</script>
</head>
<!--
  HOW TO USE: 
  data-theme: default (default), dark, light
  data-layout: fluid (default), boxed
  data-sidebar-position: left (default), right
  data-sidebar-behavior: sticky (default), fixed, compact
-->

<body data-theme="light" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          {{-- <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
            <path d="M19.4,4.1l-9-4C10.1,0,9.9,0,9.6,0.1l-9,4C0.2,4.2,0,4.6,0,5s0.2,0.8,0.6,0.9l9,4C9.7,10,9.9,10,10,10s0.3,0,0.4-0.1l9-4
              C19.8,5.8,20,5.4,20,5S19.8,4.2,19.4,4.1z"/>
            <path d="M10,15c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,15,10.1,15,10,15z"/>
            <path d="M10,20c-0.1,0-0.3,0-0.4-0.1l-9-4c-0.5-0.2-0.7-0.8-0.5-1.3c0.2-0.5,0.8-0.7,1.3-0.5l8.6,3.8l8.6-3.8c0.5-0.2,1.1,0,1.3,0.5
              c0.2,0.5,0,1.1-0.5,1.3l-9,4C10.3,20,10.1,20,10,20z"/>
          </svg> --}}

          <i class="align-middle" data-feather="coffee"></i>
          <span class="align-middle mr-3">Cafè Rueda</span>
        </a>

				<ul class="sidebar-nav">
					{{-- <li class="sidebar-item">
						<a href="#dashboards" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboards</span>
            </a>
						<ul id="dashboards" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="dashboard-default.html">Default</a></li>
						</ul>
					</li> --}}

					{{-- <li class="sidebar-item">
						<a href="#ui" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="grid"></i> <span class="align-middle">UI Elements</span>
            </a>
						<ul id="ui" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="ui-alerts.html">Alerts</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-buttons.html">Buttons</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-cards.html">Cards</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-carousel.html">Carousel</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-embed-video.html">Embed Video</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-general.html">General <span class="badge badge-sidebar-primary">10+</span></a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-grid.html">Grid</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-modals.html">Modals</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-tabs.html">Tabs</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="ui-typography.html">Typography</a></li>
						</ul>
					</li> --}}

					{{-- <li class="sidebar-item">
						<a href="#forms" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
            </a>
						<ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="forms-layouts.html">Layouts</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="forms-basic-inputs.html">Basic Inputs</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="forms-input-groups.html">Input Groups</a></li>
						</ul>
					</li> --}}

					{{-- <li class="sidebar-item">
						<a class="sidebar-link" href="tables-bootstrap.html">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Tables</span>
            </a>
					</li> --}}

					{{-- <li class="sidebar-item">
						<a href="#form-plugins" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Form Plugins</span>
            </a>
						<ul id="form-plugins" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="forms-advanced-inputs.html">Advanced Inputs</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="forms-editors.html">Editors</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="forms-validation.html">Validation</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="forms-wizard.html">Wizard</a></li>
						</ul>
					</li> --}}

					{{-- <li class="sidebar-item">
						<a href="#datatables" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">DataTables</span>
            </a>
						<ul id="datatables" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="tables-datatables-responsive.html">Responsive Table</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="tables-datatables-buttons.html">Table with Buttons</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="tables-datatables-column-search.html">Column Search</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="tables-datatables-multi.html">Multi Selection</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="tables-datatables-ajax.html">Ajax Sourced Data</a></li>
						</ul>
					</li> --}}

					@foreach($parent as $key => $p)
						<li class="sidebar-item">
							<a href="#{{ strtolower(str_replace(" ", "", $p->parentname)) }}" data-toggle="collapse" class="sidebar-link collapsed">
	              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">{{ $p->parentname }}</span>
	            </a>
							<ul id="{{ strtolower(str_replace(" ", "", $p->parentname)) }}" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
	            @foreach($child as $k => $c)
	            	@if($p->parentid == $c->parentid)
										<li class="sidebar-item"><a class="sidebar-link" href="{{ $c->url }}">{{ $c->childname }}</a></li>
										{{-- <li class="sidebar-item"><a class="sidebar-link" href="/suppliers">Suppliers</a></li> --}}
	            	@endif
	            @endforeach
							</ul>
						</li>
					@endforeach

{{-- 					<li class="sidebar-item">
						<a href="#masterfile" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Masterfile</span>
            </a>
						<ul id="masterfile" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="/items">Items</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="/suppliers">Suppliers</a></li>
						</ul>
					</li>
					<li class="sidebar-item">
						<a href="#masters" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Masters</span>
            </a>
						<ul id="masters" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="/category">Category</a></li>
						</ul>
					</li>
					<li class="sidebar-item">
						<a href="#cashier" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Cashier</span>
            </a>
						<ul id="cashier" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="/POS">POS</a></li>
						</ul>
					</li>
					<li class="sidebar-item">
						<a href="#inventory" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Inventory</span>
            </a>
						<ul id="inventory" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="/IS">Inventory Setup</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="/IR">Inventory Receiving</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="/AJ">Inventory Adjustment</a></li>
						</ul>
					</li>
					<li class="sidebar-item">
						<a href="#settings" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Settings</span>
            </a>
						<ul id="settings" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
							<li class="sidebar-item"><a class="sidebar-link" href="/user">Manage User</a></li>
							<li class="sidebar-item"><a class="sidebar-link" href="/roles">Manage Role</a></li>
						</ul>
					</li> --}}
					<li class="sidebar-item">
						<a href="#multi" data-toggle="collapse" class="sidebar-link collapsed">
              <i class="align-middle" data-feather="share-2"></i> <span class="align-middle">Multi Level</span>
            </a>
						<ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
							<li class="sidebar-item">
								<a href="#multi-2" data-toggle="collapse" class="sidebar-link collapsed">
                  Two Levels
                </a>
								<ul id="multi-2" class="sidebar-dropdown list-unstyled collapse">
									<li class="sidebar-item">
										<a class="sidebar-link" href="#">Item 1</a>
										<a class="sidebar-link" href="#">Item 2</a>
									</li>
								</ul>
							</li>
							<li class="sidebar-item">
								<a href="#multi-3" data-toggle="collapse" class="sidebar-link collapsed">
                  Three Levels
                </a>
								<ul id="multi-3" class="sidebar-dropdown list-unstyled collapse">
									<li class="sidebar-item">
										<a href="#multi-3-1" data-toggle="collapse" class="sidebar-link collapsed">
                      Item 1
                    </a>
										<ul id="multi-3-1" class="sidebar-dropdown list-unstyled collapse">
											<li class="sidebar-item">
												<a class="sidebar-link" href="#">Item 1</a>
												<a class="sidebar-link" href="#">Item 2</a>
											</li>
										</ul>
									</li>
									<li class="sidebar-item">
										<a class="sidebar-link" href="#">Item 2</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<!-- <form class="d-none d-sm-inline-block">
					<div class="input-group input-group-navbar">
						<input type="text" class="form-control" placeholder="Search projects…" aria-label="Search">
						<div class="input-group-append">
							<button class="btn" type="button">
                <i class="align-middle" data-feather="search"></i>
              </button>
						</div>
					</div>
				</form> -->

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell-off"></i>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">6h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.1</div>
												<div class="text-muted small mt-1">8h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Anna accepted your request.</div>
												<div class="text-muted small mt-1">12h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded-circle mr-1" alt="Chris Wood" /> <span class="text-dark">Chris Wood</span>
              </a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="pages-settings.html">Settings & Privacy</a>
								<a class="dropdown-item" href="#">Help</a>
								<a class="dropdown-item" href="#">Sign out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
					<!-- <h1 class="h3 mb-3">Items</h1> -->
					@yield('content')
				</div>
			</main>
		</div>
	</div>
	<script src="/js/js/app.js"></script>
	<script src="/plugins/filter-tags/autofilter.js"></script>
	<script src="/plugins/nprogress/nprogress.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Datatables Responsive
			// var table = $("#datatables-reponsive").DataTable({
			// 	responsive: true,
			// 	"dom": '<"top"f>rt<"bottom"ip><"clear">',
			// 	"pageLength": 10,
			// 	"scrollY" : "250px",
			// 	"scrollX" : true,
			// 	"scrollCollapse" : true,
			// 	"fixedHeader" : true,
			// });

			// $(".select2").each(function() {
			// 	$(this)
			// 		.wrap("<div class=\"position-relative\"></div>")
			// 		.select2({
			// 			placeholder: "Select value",
			// 			dropdownParent: $(this).parent()
			// 		});
			// });

			$("input").attr('autocomplete', 'off');
		});
	</script>
</body>


<!-- Mirrored from appstack.bootlab.io/calendar.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 04 Jan 2021 13:06:37 GMT -->
</html>