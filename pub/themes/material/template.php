<?php // Adds X-Frame-Options to HTTP header, so that page can only be shown in an iframe of the same site.
header('X-Frame-Options: SAMEORIGIN'); // FF 3.6.9+ Chrome 4.1+ IE 8+ Safari 4+ Opera 10.5+
$user = $this->ion_auth->user()->row();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $page_heading; ?> - <?php echo config_item('app_name'); ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="all,follow">

	<link rel="stylesheet" href="<?php echo site_url('npm/bootstrap/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('npm/font-awesome/css/font-awesome.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('themes/material/css/src/fontastic.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('npm/alertify/themes/alertify.core.css'); ?>" />
	<link rel="stylesheet" href="<?php echo site_url('npm/alertify/themes/alertify.bootstrap.css'); ?>" />
	<link rel="stylesheet" href="<?php echo site_url('themes/material/css/src/style.sea.css'); ?>" id="theme-stylesheet">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">

	<link rel="shortcut icon" href="<?php echo site_url('themes/material/img/favicon.png'); ?>">
	<!-- Tweaks for older IEs--><!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

	<?php echo $_styles; // loads additional css files ?>

	<link rel="stylesheet" href="<?php echo site_url('themes/material/css/styles.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('themes/material/css/responsive.min.css'); ?>" />
</head>
<body>
	<div class="page">
		<!-- Main Navbar-->
		<header class="header">
			<nav class="navbar">
				<!-- Search Box-->
				<div class="search-box">
					<button class="dismiss"><i class="icon-close"></i></button>
					<form id="searchForm" action="#" role="search">
						<input type="search" placeholder="What are you looking for..." class="form-control">
					</form>
				</div>
				<div class="container-fluid">
					<div class="navbar-holder d-flex align-items-center justify-content-between">
						<!-- Navbar Header-->
						<div class="navbar-header">
							<!-- Navbar Brand -->
							<a href="<?php echo site_url(''); ?>" class="navbar-brand d-none d-sm-inline-block">
								<div class="brand-text d-none d-lg-inline-block"><img src="<?php echo getenv('UPLOAD_ROOT'); ?>data/images/ortigaslogo.png" width="300px"></div>
								<div class="brand-text d-none d-sm-inline-block d-lg-none"><?php echo implode('', array_map(function($v) { return $v[0]; }, explode(' ', config_item('app_name')))); ?></div>
							</a>
							
							<!-- Toggle Button-->
							<a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
						</div>

						<!-- Navbar Menu -->
						<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
							<!-- Search-->
							<!-- <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li> -->
							<!-- Notifications-->
							<!-- <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span class="badge bg-red badge-corner">12</span></a>
								<ul aria-labelledby="notifications" class="dropdown-menu">
									<li><a rel="nofollow" href="#" class="dropdown-item"> 
											<div class="notification">
												<div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div>
												<div class="notification-time"><small>4 minutes ago</small></div>
											</div></a></li>
									<li><a rel="nofollow" href="#" class="dropdown-item"> 
											<div class="notification">
												<div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
												<div class="notification-time"><small>4 minutes ago</small></div>
											</div></a></li>
									<li><a rel="nofollow" href="#" class="dropdown-item"> 
											<div class="notification">
												<div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
												<div class="notification-time"><small>4 minutes ago</small></div>
											</div></a></li>
									<li><a rel="nofollow" href="#" class="dropdown-item"> 
											<div class="notification">
												<div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
												<div class="notification-time"><small>10 minutes ago</small></div>
											</div></a></li>
									<li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications																						</strong></a></li>
								</ul>
							</li> -->
							

							<!-- Account dropdown -->
							<li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img width="25" class="rounded-circle" src="<?php echo site_url($user->photo); ?>" alt="<?php echo $user->first_name; ?>" /><span class="d-none d-sm-inline-block">Account</span></a>
								<ul aria-labelledby="languages" class="dropdown-menu">
									<li>
										<a href="<?php echo site_url('users/password'); ?>" data-toggle="modal" data-target="#modal" class="dropdown-item">
											<span class="fa fa-lock"></span>
											Change Password
										</a>
									</li>

									<li>
										<a href="<?php echo site_url('users/profile'); ?>" data-toggle="modal" data-target="#modal" class="dropdown-item">
											<span class="fa fa-user"></span>
											Change Profile
										</a>
									</li>

									<li>
										<a href="<?php echo site_url('users/photo'); ?>" class="dropdown-item">
											<span class="fa fa-file-image-o"></span>
											Change Photo
										</a>
									</li>

									<li class="divider"></li>

									<li>
										<a href="<?php echo site_url('users/logout'); ?>" class="dropdown-item">
											<span class="fa fa-power-off"></span>
											Logout
										</a>
									</li>
								</ul>
							</li>

						</ul>
					</div>
				</div>
			</nav>
		</header>
		<div class="page-content d-flex align-items-stretch"> 
			<!-- Side Navbar -->
			<nav class="side-navbar">
				<!-- Sidebar Header-->
				<div class="sidebar-header d-flex align-items-center">
					<div class="avatar"><img src="<?php echo site_url($user->photo); ?>" alt="<?php echo $user->first_name; ?>" class="img-fluid rounded-circle img-thumbnail p-0"></div>
					<div class="title">
						<h1 class="h4"><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h1>
						<p><?php echo $user->company; ?></p>
					</div>
				</div>
				
				<!-- Sidebar Navigation Menus-->
				<?php echo $this->app_menu->show(); ?>
				<!-- <span class="heading">Main</span>
				<ul class="list-unstyled">
					<li><a href="index.html"> <i class="icon-home"></i>Home </a></li>
					<li class="active"><a href="tables.html"> <i class="icon-grid"></i>Tables </a></li>
					<li><a href="charts.html"> <i class="fa fa-bar-chart"></i>Charts </a></li>
					<li><a href="forms.html"> <i class="icon-padnote"></i>Forms </a></li>
					<li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Example dropdown </a>
						<ul id="exampledropdownDropdown" class="collapse list-unstyled ">
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
							<li><a href="#">Page</a></li>
						</ul>
					</li>
					<li><a href="login.html"> <i class="icon-interface-windows"></i>Login page </a></li>
				</ul>
				<span class="heading">Extras</span>
				<ul class="list-unstyled">
					<li> <a href="#"> <i class="icon-flask"></i>Demo </a></li>
					<li> <a href="#"> <i class="icon-screen"></i>Demo </a></li>
					<li> <a href="#"> <i class="icon-mail"></i>Demo </a></li>
					<li> <a href="#"> <i class="icon-picture"></i>Demo </a></li>
				</ul> -->
			</nav>
			<div class="content-inner">
				<!-- Page Header-->
				<header class="page-header">
					<div class="container-fluid">
						<h2 class="no-margin-bottom">
							<?php echo $page_heading; ?>
							<small>
								<i class="fa fa-angle-double-right"></i>
								<?php echo $page_subhead; ?>
							</small>
						</h2>
					</div>
				</header>
				<!-- Breadcrumb-->
				<div class="breadcrumb-holder container-fluid">
					<?php echo $this->breadcrumbs->show(); ?>
				</div>
				
				<main>
					<?php echo $content; ?>
				</main>

				<!-- Page Footer-->
				<footer class="main-footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<p>&copy; <?php echo date('Y'); ?> <?php echo config_item('app_name'); ?> v.<?php echo config_item('app_version'); ?> / Codifire v.<?php echo CF_VERSION; ?></p>
							</div>
							<div class="col-sm-6 text-right">
								<p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Bootstrapious</a></p>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
		<div class="modal-dialog modal modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalLabel"><?php echo lang('loading')?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="text-center">
						<img src="<?php echo site_url('ui/images/loading3.gif')?>" alt="<?php echo lang('loading')?>" />
						<p><?php echo lang('loading')?></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade bd-example-modal-lg" id="modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo lang('loading')?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="text-center">
						<img src="<?php echo site_url('ui/images/loading3.gif')?>" alt="<?php echo lang('loading')?>" />
						<p><?php echo lang('loading')?></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	
	<script>
		var site_url = '<?php echo site_url(); ?>';
		var asset_url = '<?php echo getenv('UPLOAD_ROOT'); ?>';
	</script>
	<?php if (NULL !== config_item('website_url')): ?>
		<script>var website_url = '<?php echo config_item('website_url'); ?>';</script>
	<?php endif; ?>

	<!-- JavaScript files-->
	<script src="<?php echo site_url('npm/jquery/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('npm/popper.js/umd/popper.min.js'); ?>"> </script>
	<script src="<?php echo site_url('npm/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo site_url('npm/jquery.cookie/jquery.cookie.js'); ?>"></script>
	<script src="<?php echo site_url('npm/alertify/lib/alertify.min.js'); ?>"></script>

	<!-- Main File-->
	<script src="<?php echo site_url('themes/material/js/front.js'); ?>"></script>
	<script src="<?php echo site_url('themes/material/js/scripts.min.js'); ?>"></script>

	<?php echo $_scripts; // loads additional js files from the module ?>

	<?php if (isset($error_message)): ?>
		<script>alertify.error("<?php echo $error_message; ?>");</script>
	<?php endif; ?>

	<?php if (isset($message)): ?>
		<script>alertify.success("<?php echo $message; ?>");</script>
	<?php endif; ?>

	<?php if (NULL != $this->session->flashdata('flash_message')): ?>
		<script>alertify.success("<?php echo $this->session->flashdata('flash_message'); ?>");</script>
	<?php endif; ?>

	<?php if (NULL != $this->session->flashdata('flash_error')): ?>
		<script>alertify.error("<?php echo $this->session->flashdata('flash_error'); ?>");</script>
	<?php endif; ?>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN6cUNcHO88eddYIc5mo4nW4t-sOPILCE&libraries=places&callback=initMap" type="text/javascript"></script>
</body>
</html>