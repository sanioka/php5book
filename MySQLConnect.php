<?php
require "MySQLResultSet.php";

class MySQLConnect
{
    private $connection;
    static $instances = 0;

    public function __construct($hostname, $username, $password)
    {
        if (self::$instances == 0) {
            $this->connection = mysql_connect($hostname, $username, $password) or
            die(mysql_error() . 'Ошибка #' . mysql_errno());
            self::$instances = 1;
        } else {
            die('Закройте предыдущее соединение');
        }

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function close()
    {
        self::$instances = 0;
        if (isset($this->connection)) {
            mysql_close($this->connection);
            unset($this->connection);
        }
    }

    public function createResultSet($strSQL, $databasename) {
        $rs = new MySQLResultSet($strSQL, $databasename, $this->connection);
        return $rs;
    }

}