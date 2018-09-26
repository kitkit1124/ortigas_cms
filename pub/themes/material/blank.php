<?php // Adds X-Frame-Options to HTTP header, so that page can only be shown in an iframe of the same site.
header('X-Frame-Options: SAMEORIGIN'); // FF 3.6.9+ Chrome 4.1+ IE 8+ Safari 4+ Opera 10.5+
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo config_item('app_name'); ?> - <?php echo $page_heading; ?></title>
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
	
	<main>
		<?php echo $content; ?>
	</main>

	<script>var site_url = '<?php echo site_url(); ?>';</script>

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
</body>
</html>