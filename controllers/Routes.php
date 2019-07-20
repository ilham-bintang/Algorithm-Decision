<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

class Routes
{

    private $_depths = array();

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    public function _init()
    {
        $_str = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
        if ($_str) {
            if ($_pos = strpos($_str, '?'))
                $_str = substr($_str, 0, $_pos);
            $_tmp = explode(DS, $_str);
            array_shift($_tmp);
            $this->_depths = array_filter($_tmp);
        }
        return $this;
    }

    public function _depth($x = 0, $camel_case = false)
    {
        $_tmp = isset($this->_depths[$x]) ? $this->_depths[$x] : '';
        return $camel_case ? Util::_camel_case($_tmp) : $_tmp;
    }

    public function _is_depth($x, $str, $camel_case = false)
    {
        return self::_depth($x, $camel_case) == $str;
    }

    public function _depths()
    {
        return $this->_depths;
    }

    public function _render($x = 0, $prefix = 'page-')
    {
        $_file_name = $prefix . (empty($this->_depths) ? Util::page_beranda : self::_depth($x));
        $_file_path = ABS_VIEW_PATH . DS . $_file_name . '.php';
        include_once file_exists($_file_path) ? $_file_path : ABS_VIEW_PATH . DS . Util::page_404 . ($x > 0 ? '-content' : '') . '.php';
    }
}