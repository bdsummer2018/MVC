<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.02.2019
 * Time: 19:39
 */

namespace core\db;
use core\Configurator;

class DBQueryBuilder
{
    private $dbh;

    private $quury_parts = [
        "where" => [],
        "having" => [],
        "order" => [],
        "groupby"=>[],
        "limit" => null,
        "offset" => null,
        "join" => [],
        "fields" => [],
        "table" => null
    ];

    /**
     * DBQueryBuilder constructor.
     */
    public function __construct($name = "default")
    {
        $config = new Configurator("db");
        $cfg = $config->$name;

        $this->dbh = new \PDO("mysql:host={$cfg["host"]};port={$cfg["port"]};dbname={$cfg["name"]};charset={$cfg["charset"]}",
            $cfg["user"],$cfg["pass"]);
    }

    //SELECT vasia.dsf FROM ... WHERE ... ORDER BY ... LIMIT ... OFFSET ...

    private static function _field($f)
    {
        return "`" . str_replace('.', '`.`', $f) . "`";
    }

    public function select(array $fields)
    {
        $this->quury_parts["fields"] = array_map(function ($f) {
            return self::_field($f);
        }, $fields);
        return $this;
    }

    public function from(string $table){
        $this->quury_parts["table"] = self::_field($table);
        return $this;
    }

    private function _where($type,$field,$sign,$value,bool $native){
        if($value===null) {
            $value = $sign;
            $sign = "=";
        }
        if(!$native) $field = self::_field($field);
        if(!$native && $value[0]!="?" && $value[0]!=":" && !is_integer($value)) $value=$this->dbh->quote($value);
        $this->quury_parts["where"][] = [$type,$field,$sign,$value];
    }

    public function where($field,$sign,$value=null,bool $native=false){
        $this->_where("",$field,$sign,$value,$native);
        return $this;
    }
    public function andWhere($field,$sign,$value=null,bool $native=false){
        $this->_where("AND",$field,$sign,$value,$native);
        return $this;
    }
    public function orWhere($field,$sign,$value=null,bool $native=false){
        $this->_where("OR",$field,$sign,$value,$native);
        return $this;
    }
    private function _groupWhere(callable $where,$type){
        if($type!=null) $this->quury_parts["where"][]=[$type];
        $this->quury_parts["where"][]=["("];
        $where($this);
        $this->quury_parts["where"][]=[")"];
        return $this;
    }
    public function whereGroup(callable $where){
        return $this->_groupWhere($where,null);
    }
    public function andWhereGroup(callable $where){
        return $this->_groupWhere($where,"AND");
    }
    public function orWhereGroup(callable $where){
        return $this->_groupWhere($where,"OR");
    }

    private function buildSelect(){
        $fields = empty($this->quury_parts["fields"])?"*":implode(", ",$this->quury_parts["fields"]);

        $q = "SELECT {$fields} FROM {$this->quury_parts["table"]}";

        if(!empty($this->quury_parts["where"])){
            $q.=" WHERE";
            foreach ($this->quury_parts["where"] as $w){
                $q.=" {$w[0]} ";
                if(count($w)>1) $q.="({$w[1]} {$w[2]} {$w[3]})";
            }
        }
        return $q;

    }

    public function all($data=[]){
        $q = $this->buildSelect();
        $stmt= $this->dbh->prepare($q);
        $stmt->execute($data);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



}
