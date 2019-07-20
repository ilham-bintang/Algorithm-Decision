<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element text-center">
                    <a href="<?php echo Util::_a(Util::page_beranda); ?>">
                        <span>
                            <img alt="image" class="img-circle" src="<?php echo URI_IMG_PATH; ?>/logo.png"
                                 style="max-width: 75px"/>
                        </span>
                        <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        {{ nama }}
                                    </strong>
                                </span>
                                <span class="text-muted text-xs block">
                                    <?php echo APP_AUTHOR; ?>
                                </span>
                            </span>
                    </a>
                </div>
                <div class="logo-element">
                    <?php echo APP_INITIAL; ?>
                </div>
            </li>

            <?php foreach (Util::$_bidang as $_i => $_pages) : ?>
                <li class="<?php echo Routes::_gi()->_is_depth(1, $_i) ? 'active' : ''; ?>">
                    <a href="#">
                        <i class="fa <?php echo Util::$_bidang_icon[$_i]; ?>"></i>
                        <span class="nav-label">Bidang <?php echo $_i; ?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <?php foreach ($_pages as $_page) : ?>
                            <li class="<?php echo Routes::_gi()->_is_depth(2, $_page) ? 'active' : ''; ?>">
                                <a href="<?php echo Util::_a_bidang($_i, $_page); ?>"><?php echo Util::_camel_case($_page); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>

        </ul>

    </div>
</nav>
