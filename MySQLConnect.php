<?php
require "MySQLResultSet.php";
require "MySQLException.php";

class MySQLConnect
{
    private $connection;
    static $instances = 0;
    const ONLY_ONE_INSTANCE_ALLOWED = 5000;
    private static $instance = NULL;

    public static function getInstance($hostname, $username, $password)
    {
        if (self::$instance == NULL) {
            self::$instance = new MySQLConnect($hostname, $username, $password);
            return self::$instance;
        } else {
            $msg = 'Закройте существующий экземпляр класса MySQLConnect.';
            throw new MySQlException($msg, self::ONLY_ONE_INSTANCE_ALLOWED);
        }
    }

    private function __construct($hostname, $username, $password)
    {
        if (!$this->connection = mysql_connect($hostname, $username, $password)) {
            throw new MySQlException(mysql_error(), mysql_errno());
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

    public function createResultSet($strSQL, $databasename)
    {
        $rs = new MySQLResultSet($strSQL, $databasename, $this->connection);
        return $rs;
    }

}