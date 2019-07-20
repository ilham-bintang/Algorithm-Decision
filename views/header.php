<?php

global $page_title;

$_styles = array(
    'bootstrap.min.css',
    'font-awesome.css',
    'animate.css',
    'style.css',
    'custom.css',
);

$_scripts = array(
    'jquery-2.1.1.js',
    'jquery.mask.min.js',
    'bootstrap.min.js',
    'plugins/metisMenu/jquery.metisMenu.js',
    'plugins/slimscroll/jquery.slimscroll.min.js',
    'inspinia.js',
    'plugins/pace/pace.min.js',
    'plugins/jquery-ui/jquery-ui.min.js',
    'plugins/toastr/toastr.min.js',
    'plugins/sweetalert/sweetalert.min.js',
    'script.js'
);

ob_start('minify_HTML'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $page_title ? $page_title . ' | ' . APP_NAME : APP_NAME . ' | ' . APP_AUTHOR; ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <?php foreach ($_styles as $_style) : ?>
        <link href="<?php echo URI_CSS_PATH . DS . $_style; ?>" rel="stylesheet">
    <?php endforeach; ?>

    <link rel="shortcut icon" type="image/png" href="<?php echo URI_IMG_PATH; ?>/fav.png" sizes="16x16"/>


    <?php foreach ($_scripts as $_script) : ?>
        <script src="<?php echo URI_JS_PATH . DS . $_script; ?>"></script>
    <?php endforeach; ?>


</head>

<body class="top-navigation">
<div id="wrapper">