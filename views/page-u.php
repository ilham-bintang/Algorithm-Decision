<?php

global $page_title;

Util::_header();

?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <?php include_once 'header-nav.php'; ?>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            <?php Routes::_gi()->_render(1, Util::dir_user . DS); ?>
        </div>
    </div>

<?php Util::_footer();