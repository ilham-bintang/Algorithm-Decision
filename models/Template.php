<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

interface Template
{
    public function _id();

    public function _init($request);

    public function _toArray();
}