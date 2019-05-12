<?php

namespace App\Custom;

class CssClass{
    protected $name;
    protected $props = [];

    public function __construct($name){
        $this->name = $name;
    }

    public function setProp($name, $value){
        $this->props[$name] = $value;
        return $this;
    }

    public function build(){
        $header = ".{$this->name} {\n";
        $content = "";
        $footer = "}\n\n";

        foreach ($this->props as $key => $val){
            $content .= "\t{$key}: {$val};\n";
        }

        return $header . $content . $footer;
    }
}