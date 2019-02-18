<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 13.02.2019
 * Time: 19:39
 */

namespace core\db;


class DBQueryBuilder
{


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
    private $executor;
    private $class;
    const DEF_CONFIG_NAME = "default";


    public function __construct($name = self::DEF_CONFIG_NAME,$class=null)
    {
        $this->class=$class;
        $this->executor = DBExecutor::instance($name);
    }

    public static function create($name = self::DEF_CONFIG_NAME,$class=null){
        return new self($name,$class);
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
        if(!$native && $value[0]!="?" && $value[0]!=":" && !is_integer($value)) $value=$this->executor->quote($value);
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

    private function buildWhere(){
        $q="";
        if(!empty($this->quury_parts["where"])){
            $q.=" WHERE";
            foreach ($this->quury_parts["where"] as $w){
                $q.=" {$w[0]} ";
                if(count($w)>1) $q.="({$w[1]} {$w[2]} {$w[3]})";
            }
        }
        return $q;
    }

    private function buildSelect(){
        $fields = empty($this->quury_parts["fields"])?"*":implode(", ",$this->quury_parts["fields"]);

        $q = "SELECT {$fields} FROM {$this->quury_parts["table"]}";
        $q.=$this->buildWhere();
        return $q;

    }

    public function all($data=[]){
        return $this->executor->executeSelect($this->buildSelect(),$data);
    }
    public function get($data=[]){
        return array_map(function ($x){
            return new $this->class($x);
        },$this->all($data));
    }

    public function one($data=[]){
        return $this->executor->executeSelectOne($this->buildSelect(),$data);
    }
    public function first($data=[]){
        $q = $this->one($data);
        return $q ? new $this->class($q) : null;
    }

    public function insert($table,array $data){
        $fields = implode("`,`",array_keys($data));
        $values = implode(", :",array_keys($data));
        $q ="INSERT INTO `{$table}` (`{$fields}`) VALUES (:{$values})";
        return $this->executor->executeInsert($q,$data);
    }

    public function update($table,array $data,array $params=[]){
        $where = $this->buildWhere();
        $list = implode(",",array_map(function ($f){
            return "`{$f}`=:_param_$f";
        },array_keys($data)));

        $insert_data=[];
        foreach ($data as $k=>$v){
            $insert_data["_param_{$k}"]=$v;
        }
        $q = "UPDATE {$table} SET {$list} {$where}";

        $this->executor->executeUpdate($q,array_merge($insert_data,$params));
    }

}
