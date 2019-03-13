<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 20:38
 */

namespace core\base;


use core\db\DBQueryBuilder;

abstract class Model
{
    protected static $table;

    protected function getIdName(){
        return "id";
    }

    /**
     * Model constructor.
     */
    public function __construct(array $data=[])
    {
        foreach ($data as $field=>$value){
                $this->$field=$value;
        }
    }

    public static function get(){
        $class = get_called_class();
        return DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)
            ->from($class::$table)->get();
    }

    private function parseFields(){
        $class = new \ReflectionClass(get_class($this));
        $fields = $class->getProperties();
        $arr = [];
        foreach ($fields as $field){
            if ($field->isStatic()||!$field->isPublic()) continue;
            $arr[] = $field->getName();
        }
        return $arr;
    }

    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $dbo = DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)->from($class::$table);
        return call_user_func_array([$dbo,$name],$arguments);
    }


    public function save(){
        $idname = $this->getIdName();
        $filds = $this->parseFields();
        $data = [];
        foreach ($filds as $fild){
            if(is_null($this->$fild)) continue;
            $data[$fild]=$this->$fild;
        }
        $class = get_class($this);


        if(is_null($this->$idname)){
            $id =  DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)->insert($class::$table,$data);
            $this->$idname = $id;
        }else{
            DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)
                ->where($idname,":id")
                ->update($class::$table,$data,["id"=>$this->$idname]);
        }


    }


    protected function belongsTo($class,$current_key=null,$far_key="id"){
        if($current_key===null) $current_key = $class::$table."_id";
        return DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)
            ->from($class::$table)->where($far_key,$this->$current_key)->first();
    }

    protected function hasMany($class,$far_key=null,$current_key="id"){
        $class2 = get_class($this);
        if($far_key===null) $far_key = $class2::$table."_id";
        return DBQueryBuilder::create(DBQueryBuilder::DEF_CONFIG_NAME,$class)
            ->from($class::$table)->where($far_key,$this->$current_key);
    }




}