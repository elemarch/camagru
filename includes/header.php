<?php

session_start();
include 'functions/functions.php';
include 'config/config.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>camagru * <?php echo getPageName() ?></title>
	<link rel="stylesheet" href="styles/base.css" />
	<link rel="stylesheet" href="styles/icons.css" />
	<link rel="stylesheet" media="screen and (max-width: 674px)" href="styles/small.css" />
	<link rel="stylesheet" media="screen and (min-width: 675px)" href="styles/full.css" />
	<link href="https://fonts.googleapis.com/css?family=Coiny|Rubik:300,500,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	<?php include 'includes/menu.php';?>
	<div id='content'>