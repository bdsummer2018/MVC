<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:15
 */
namespace core\router;
class Route{
    private $params;
    private $url_components = [];

    const PARAM_REXP = '/\{\??([a-z][a-z0-9]*)\}/i';
    const OPT_PARAM_REXP = '/\{\?([a-z][a-z0-9]*)\}/i';

    private function isParam($name,$value){
        if(!preg_match(self::PARAM_REXP,$name,$arr)) return false;
        $param_name = $arr[1];
        $this->params[$param_name] = strtolower($value);
        return true;
    }

    private function isTmpParam($name){
        return preg_match(self::OPT_PARAM_REXP,$name);
    }

    public function __construct($url,array $params=[])
    {
        $this->url_components = explode("/",$url);
        $this->params = $params;
    }

    public function getControllerName(){
        return @$this->params["controller"];
    }
    public function getActionName(){
        return @$this->params["action"];
    }

    public function match():bool {
        $uri = $_SERVER["REQUEST_URI"];
        $pos = strpos($uri,"?");
        $uri =  trim(($pos===false ? $uri : substr($uri,0,$pos)),"/");
        $components = explode('/',$uri);


        if(count($components)>count($this->url_components)) return false;
        if(empty($components[0]) && empty($this->url_components[0])) return true;

        for ($i=0;$i<count($this->url_components);$i++){
            if(!empty($components[$i]) && $components[$i]===$this->url_components[$i]) continue;
            if(empty($components[$i]) && $this->isTmpParam($this->url_components[$i])) return true;
            if(empty($components[$i])) return false;
            if(!$this->isParam($this->url_components[$i],$components[$i]))return false;
        }

        return true;
    }

    public function getParam($name,$def=null){
        if(empty($this->params[$name])) return $def;
        return $this->params[$name];
    }

}