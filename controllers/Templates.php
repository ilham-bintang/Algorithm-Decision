<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

interface Templates
{
    public function _get($key, $by);

    public function _gets($args);

    public function _insert($obj);

    public function _update($obj);

    public function _delete($id);

    public function _count();
}