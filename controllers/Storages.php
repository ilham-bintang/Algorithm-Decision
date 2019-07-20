<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

class Storages extends Databases
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $__CLASS__
     * @param $__ID__
     * @param $obj Template
     * @return bool
     */
    protected function _s_insert($__CLASS__, $__ID__, $obj)
    {
        $_values = $obj->_toArray();
        $_columns = Util::_filter_class_attr(
            array_keys($_values),
            Util::type_attribute_primary,
            array($__ID__)
        );
        return $this->insert(
            Util::_table_name($__CLASS__),
            $_columns,
            array(
                array_map(function ($k) use ($_values) {
                    return $_values[$k];
                }, $_columns)
            )
        );
    }

    /**
     * @param $__CLASS__
     * @param $__ID__
     * @param $obj Template
     * @param $_id
     * @return bool
     */
    protected function _s_update($__CLASS__, $__ID__, $obj, $_id)
    {
        $_values = $obj->_toArray();
        $_columns = Util::_filter_class_attr(
            array_keys($_values),
            Util::type_attribute_primary,
            array($_id)
        );
        return $this->update(
            Util::_table_name($__CLASS__),
            $_columns,
            array_map(function ($k) use ($_values) {
                return $_values[$k];
            }, $_columns),
            array($__ID__, $_id)
        );
    }

    /**
     * @param $__CLASS__
     * @param $__ID__
     * @param $_id
     * @return bool
     */
    protected function _s_delete($__CLASS__, $__ID__, $_id)
    {
        return parent::delete(
            Util::_table_name($__CLASS__), $__ID__, $_id
        );
    }

    /**
     * @param $__CLASS__
     * @param string $_query
     * @return int
     */
    protected function _s_count($__CLASS__, $_query = '')
    {
        return $this->_rows(empty($_query) ? 'SELECT * FROM ' . Util::_table_name($__CLASS__) : $_query);
    }
}