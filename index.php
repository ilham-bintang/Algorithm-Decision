<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

include 'init.php';

Util::_validate_URI($_SERVER);

if (empty(Routes::_gi()->_depths())) {
    /**
     * @todo
     * - cek jenis sesi user
     */
    Util::_redirect(
        Util::_a(Util::page_beranda));
} else Routes::_gi()->_render();