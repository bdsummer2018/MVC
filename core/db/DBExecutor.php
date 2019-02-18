<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 18.02.2019
 * Time: 19:52
 */

namespace core\db;
use core\Configurator;

class DBExecutor
{
    private static $instances = [];
    private $dbh;
    /**
     * DBQueryBuilder constructor.
     */
    private function __construct($name = "default")
    {
        $config = new Configurator("db");
        $cfg = $config->$name;

        $this->dbh = new \PDO("mysql:host={$cfg["host"]};port={$cfg["port"]};dbname={$cfg["name"]};charset={$cfg["charset"]}",
            $cfg["user"],$cfg["pass"]);
    }

    public static function instance($name = "default"):self{
        if(!empty(self::$instances[$name])) return self::$instances[$name];
        return self::$instances[$name] = new self($name);
    }
    public function quote($data){
        return $this->dbh->quote($data);
    }

    public function executeSelect($query,$params){
        $stmt= $this->dbh->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function executeSelectOne($query,$params){
        $stmt= $this->dbh->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function executeUpdate($qury,$params){
        $stmt = $this->dbh->prepare($qury);
        $stmt->execute($params);
    }

    public function executeInsert($qury,$params){
        $this->executeUpdate($qury,$params);
        return $this->dbh->lastInsertId();
    }
}