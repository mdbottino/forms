<?php

namespace mdbottino\Forms\Base;

abstract class BaseField {
    
    protected $name;
    protected $label;
    protected $data;
    protected $attrs = [];
    protected $type;
    protected $required = false;
    protected $required_text = null;

    protected function attr($k, $v){
        return "$k='$v'";
    }

    protected function field_attrs(){
        $attrs = array_map([$this, 'attr'], array_keys($this->attrs), $this->attrs);
        return join(' ', $attrs);
    }

    public function __construct($name, $label, array $options=null){
        $this->name = $name;
        $this->label = $label;

        if (isset($options['attrs'])){

            /* Catching it just in case*/
            if (isset($options['attrs']['required'])){
                $this->required = (boolean) $options['attrs']['required'];
                unset($options['attrs']['required']);
            }

            $attrs = $options['attrs'];
            $this->attrs = array_merge($attrs, $this->attrs);
        }

        if (isset($options['initial'])){
            $this->data = $options['initial'];
        }

        /* It will override anything set through attrs */
        if (isset($options['required'])){
            $this->required = (boolean) $options['required'];
        }
        
        if (isset($options['required_text'])){
            $this->required_text = $options['required_text'];
        }
    }

    public function setData($data){
        $this->data = $data;
    }

    public function label(){
        $label = $this->label;
        $id = $this->id();
        $required = $this->required ? $this->required_text : '';
        return "<label for='$id'>$label $required</label>\n";
    }

    public function id(){
        return "id_" . $this->name;
    }

    public function type(){
        return $this->type;
    }

    public function name(){
        return $this->name;
    }

    abstract public function widget($old);
}