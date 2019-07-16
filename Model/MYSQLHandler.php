<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySQLHandler
 *
 * @author webre
 */
class MySQLHandler implements DbHandler
{

    //put your code here
    private $_db_handler;
    private $_table;

    public function __construct($table)
    {
        $this->_table = $table;
        $this->connect();
    }

    public function connect()
    {
        $handler = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__);
        if ($handler) {
            $this->_db_handler = $handler;
            return true;
        } else {
            return false;
        }
    }

    public function disconnect()
    {
        if ($this->_db_handler) {
            mysqli_close($this->_db_handler);
        }

    }

    public function get_data($fields = array(), $start = 0)
    {
        $table = $this->_table;
        if (empty($fields)) {
            $sql = "select * from " . $table;
        } else {
            $sql = "select ";
            foreach ($fields as $f) {
                $sql .= "`$f` ,";
            }
            $sql .= " from `$table`";
            $sql = str_replace(", from", "from", $sql);
        }
        return $this->get_results($sql);
    }

    public function get_record_by_id($id, $primary_key)
    {
        $table = $this->_table;
        $sql = "select * from `$table` where `$primary_key` = $id";
        return $this->get_results($sql);
    }

    public function get_record($index)
    {
        $table = $this->_table;
        $sql = "select * from `$table` limit $index,1";
        return $this->get_results($sql);
    }

    private function get_results($sql)
    {
        if (__DEBUG_MODE__ === 1) {
            echo "<h5>Sent Query: </h5>" . $sql . "<br/> <br/>";
        }

        $_handler_results = mysqli_query($this->_db_handler, $sql);
        $_arr_results = array();

        if ($_handler_results) {
            while ($row = mysqli_fetch_array($_handler_results, MYSQLI_ASSOC)) {
                $_arr_results[] = array_change_key_case($row);
            }
            return $_arr_results;

        } else {
            return false;
        }
    }

    public function save($new_value)
    {
        if (is_array($new_value)) {
            $table = $this->_table;
            $sql1 = "insert into `$table` (";
            $sql2 = " values (";
            foreach ($new_value as $key => $value) {

                $sql1 .= "`$key` ,";
                $sql2 .= "'$value' ,";
            }
            $sql1 = $sql1 . ")";
            $sql2 = $sql2 . ")";
            $sql1 = str_replace(",)", ")", $sql1);
            $sql2 = str_replace(",)", ")", $sql2);
            $sql = $sql1 . $sql2;
            $this->debug($sql);
            if (mysqli_query($this->_db_handler, $sql)) {
                $this->disconnect();
                return true;
            } else {
                $this->disconnect();
                return false;
            }

        }
    }

    public function update($new_value, $primary_key, $id)
    {
        if (is_array($new_value)) {
            $table = $this->_table;
            $sql = "update `$table` set ";
            foreach ($new_value as $key => $value) {
                $sql .= "`$key` = '$value',";
            }
            $sql = rtrim($sql, ",");
            $sql = $sql . " where `$primary_key` = '$id'";
            $this->debug($sql);
            if (mysqli_query($this->_db_handler, $sql)) {
                $this->disconnect();
                return true;
            } else {
                $this->disconnect();
                return false;
            }

        }
    }

    public function delete($primary_key, $id)
    {
        $table = $this->_table;
        $sql = "DELETE FROM `$table` WHERE $primary_key = $id";
        $this->debug($sql);
        if (mysqli_query($this->_db_handler, $sql)) {
            $this->disconnect();
            return true;
        } else {
            $this->disconnect();
            return false;
        }
    }

    private function debug($sql)
    {
        if (__DEBUG_MODE__ === 1) {
            echo "<h5> Sent Query </h5>" . $sql . "<br>";
        }
    }

}