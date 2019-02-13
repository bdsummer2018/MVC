<?php
/**
 * Created by PhpStorm.
 * User: mamedov
 * Date: 11.02.2019
 * Time: 19:43
 */

namespace core\base;


class TemplateView extends View
{
    private $view;
    public function __construct(string $name,string $template)
    {
        $this->view = new View($name);
        parent::__construct($template);
    }


    public function render(array $data = [])
    {
        $data["content"]=$this->view->render(array_merge($data,$this->data));
        return parent::render($data);
    }

}