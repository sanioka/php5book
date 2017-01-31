<?php
require "MySQLResultSet.php";
require "MySQLException.php";

class MySQLConnect
{
    private $connection;
    static $instances = 0;
    const ONLY_ONE_INSTANCE_ALLOWED = 5000;

    public function __construct($hostname, $username, $password)
    {
        if (self::$instances == 0) {
            if (!$this->connection = mysql_connect($hostname, $username, $password)) {
                throw new MySQlException(mysql_error(), mysql_errno());
            }
            self::$instances = 1;
        } else {
            $msg = 'Закройте существующий экземпляр класса MySQLConnect.';
            throw new MySQlException($msg, self::ONLY_ONE_INSTANCE_ALLOWED);
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