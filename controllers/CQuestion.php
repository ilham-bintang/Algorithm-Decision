<?php

/**
 * File created by : Nullphantom.
 * https://nullphantom.tech
 *
 * Author : Bintang
 */

/**
 * File created by : Nullphantom.
 * https://nullphantom.tech
 *
 * Author : Bintang
 */
class CQuestion extends Storages implements Templates
{

    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    const _id = 'question_id';
    const _class = __CLASS__;

    private $_q_count;


    /**
     * @param $key
     * @param string $by
     * @return MDosen
     */
    public function _get($key, $by = self::_id)
    {
        return $this->_fetch(
            'SELECT a.*' .
            ' FROM ' . Util::_table_name(__CLASS__) . ' a' .
            ' WHERE a.`' . $by . '` = "' . $key . '"',
            false, PDO::FETCH_CLASS, Util::_model_name(__CLASS__));
    }

    /**
     * @param $args
     * @return array|mixed
     */
    public function _gets($args)
    {
        $default_args = array(
            'question_id' => 0,
            'question_text' => 0,
            'order' => 'DESC',
            'order_by' => self::_id,
            'number' => 10,
            'offset' => 0
        );

        $list_args = Util::_params($default_args, $args);

        $query = 'SELECT a.*' .
            ' FROM ' . Util::_table_name(__CLASS__) . ' a' .
            ' WHERE 1';


        $this->_q_count = $query;

        $query .= ' ORDER BY `' . $list_args['order_by'] . '` ' . $list_args['order'];

        if ($list_args['number'] >= 0)
            $query .= ' LIMIT ' . $list_args['offset'] . ', ' . $list_args['number'];



        return $this->_fetch($query, true, PDO::FETCH_CLASS, Util::_model_name(__CLASS__));
    }



    /**
     * @param $key
     * @param $column_name
     * @return bool
     */
    public function _unique($key, $column_name) {
        return $this->_fetch(
            'SELECT *  FROM ' . Util::_table_name(__CLASS__) .
            ' WHERE `' . $column_name . '` = "' . $key . '"',
            false, PDO::FETCH_CLASS, Util::_model_name(__CLASS__));
    }

    /**
     * @param $obj Template
     * @return mixed
     */
    public function _insert($obj)
    {
        return parent::_s_insert(__CLASS__, self::_id, $obj);
    }

    /**
     * @param $obj Template
     * @return mixed
     */
    public function _update($obj)
    {
        return parent::_s_update(__CLASS__, self::_id, $obj, $obj->_id());
    }

    public function _delete($_id)
    {
        return parent::_s_delete(__CLASS__, self::_id, $_id);
    }

    public function _count()
    {
        return parent::_s_count(__CLASS__, $this->_q_count);
    }
}