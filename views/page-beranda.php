<?php

ob_start('minify_HTML');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo APP_NAME; ?> | <?php echo APP_AUTHOR; ?></title>

    <link href="<?php echo URI_CSS_PATH; ?>/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/font-awesome.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/animate.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/style.css" rel="stylesheet">
    <link href="<?php echo URI_CSS_PATH; ?>/custom.css" rel="stylesheet">

    <link rel="shortcut icon" type="image/png" href="<?php echo URI_IMG_PATH; ?>/fav.ico" sizes="16x16"/>

</head>
<body id="page-top" class="landing-page">
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo URI_PATH; ?>">
                    <?php echo APP_INITIAL2; ?>
                </a>
            </div>
        </div>
    </nav>
</div>
<div>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1 class="wow zoomIn animated">
                        <?php echo APP_INITIAL2; ?>
                    </h1>
                    <p class="wow zoomIn animated">
                        <?php echo APP_NAME; ?>
                    </p>
                    <p>

                        <a href="<?php echo Util::_a_u(Util::u_question . DS . "Q1") ?>" class="btn btn-lg btn-primary">
                            Let Me In
                        </a>
                    </p>
                </div>
                <div class="carousel-image wow zoomIn animated">
                    <img src="<?php echo URI_IMG_PATH; ?>/bg.png"
                         alt="<?php echo APP_NAME; ?>">
                </div>
            </div>
            <div class="header-back"></div>
        </div>
    </div>
</div>

<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>LombokDev Meetup #7</h1>
                <p>
                    <strong>
                        <span class="navy">
                            <?php echo APP_AUTHOR ?>
                        </span>
                    </strong>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>Made with ❤️️ in Lombok island</strong></p>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo URI_JS_PATH; ?>/jquery-2.1.1.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/bootstrap.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/inspinia.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/pace/pace.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/plugins/wow/wow.min.js"></script>
<script src="<?php echo URI_JS_PATH; ?>/beranda.js"></script>

</body>
</html>
