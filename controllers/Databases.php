<?php
/**
 * LRsoft Corp.
 * http://lrsoft.co.id
 *
 * Author : Zaf
 */

class Databases
{
    /** @var PDO $_DBH */
    protected $_DBH;

    /** @var PDOStatement $_STH */
    protected $_STH;

    /** @var self $_i */
    private static $_i;

    public static function _gi()
    {
        if (!isset(self::$_i)) {
            self::$_i = new self();
        }
        return self::$_i;
    }

    /**
     * koneksi langsung saat class di instance
     *
     * @author Zaf
     */
    function __construct()
    {
        $this->_connect();
    }

    /**
     * koneksi ke database
     *
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     * @param bool $new_link
     */
    function _connect($host = DB_HOST, $name = DB_NAME, $user = DB_USER, $pass = DB_PASS, $new_link = false)
    {

        try {
            $this->_DBH = new PDO('mysql:host=' . $host . ';dbname=' . $name, $user, $pass, array(
                PDO::ATTR_ERRMODE => defined('LRS_DB_ERRMODE') ? LRS_DB_ERRMODE : PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => !$new_link
            ));
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

    }


    /**
     * eksekusi query tanpa ada pengembalian data
     *
     * @param $query
     * @return int
     */
    protected function _exec($query)
    {
        try {
            return $this->_DBH->exec($query);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * eksekusi query dengan data return
     *
     * @param $query
     * @param bool $all
     * @param int $mode
     * @param string $class
     * @return array|mixed
     */
    protected function _fetch($query, $all = false, $mode = PDO::FETCH_ASSOC, $class = '')
    {
        try {

            /**
             * saat `class_name` tidak ditentukan,
             * gunakan parameter `$mode` untuk fetch style
             */
            if (empty($class))
                return $all ?
                    $this->_DBH->query($query)->fetchAll($mode) :
                    $this->_DBH->query($query)->fetch($mode);

            /**
             * jika `class_name` ditentukan bisa dipastikan
             * kalau jenis fetch adalah objek (FETCH_CLASS)
             */
            else
                return $all ?
                    $this->_DBH->query($query)->fetchAll($mode, $class) :
                    $this->_DBH->query($query)->fetchObject($class);

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * jumlah row yang dihasilkan dari suatu query
     *
     * @param $query
     * @return int
     */
    protected function _rows($query)
    {
        try {
            return $this->_DBH->query($query)->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * jumlah kolom yang dihasilkan dari suatu query
     *
     * @param $query
     * @return int
     */
    protected function _fields($query)
    {
        try {
            return $this->_DBH->query($query)->columnCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * fungsi buat insert value
     *
     * @author Zaf
     * @param string $table
     * @param array $column
     * @param array $value
     * @return bool $res
     */
    protected function insert($table, $column = array(), $value = array())
    {

        $values = array();
        $number_of_value = count($value);
        $query = 'INSERT INTO ' . $table . ' ( ' . implode(', ', $column) . ' ) VALUES ';

        foreach ($value as $k => $v) {
            $values = array_merge($values, $v);
            $query .= '(' . implode(', ', array_fill(0, count($v), '?')) . ')' .
                ($k < ($number_of_value - 1) ? ', ' : '');
        }

        $this->_STH = $this->_DBH->prepare($query);

        try {
            $this->_STH->execute($values);
            return $this->_DBH->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

    }

    /**
     * fungsi standar buat update value,
     *
     * @author Zaf
     * @param string $table
     * @param array $column
     * @param array $value
     * @param array $condition
     * @return bool
     */
    protected function update($table, $column = array(), $value = array(), $condition = array())
    {
        $query = 'UPDATE ' . $table . ' SET ';

        foreach ($column as $k => $c)
            $query .= $c . ' = ?' . ($c != end($column) ? ', ' : '');

        if (!empty($condition))
            $query .= ' WHERE ' . $condition[0] . ' = "' . $condition[1] . '"';

        $this->_STH = $this->_DBH->prepare($query);

        try {
            return $this->_STH->execute($value);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

    }

    /**
     * fungsi buat delete value
     *
     * @author Zaf
     * @param string $table
     * @param string $column
     * @param string $value
     * @return bool
     */
    protected function delete($table, $column, $value)
    {
        $query = 'DELETE FROM `' . $table . '` WHERE `' . $column . '` = "' . $value . '"';
        return $this->_exec($query);
    }

}