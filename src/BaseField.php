<?php

namespace mdbottino\Forms;

abstract class BaseField {
    

    protected $name;
    protected $label;
    protected $label_class = null;
    protected $data;
    protected $attrs = [];
    protected $type;
    protected $required = false;
    protected $required_text = null;

    protected $valid_attrs = [
        'class',
        'size',
        'required',
        'readonly',
        'disabled',
        'formnovalidate',
        'pattern',
        'form',
        'autofocus',
        'autocomplete',
    ];
    
    protected $valid_field_attrs = [];

    protected function attr($k, $v){
        return "$k='$v'";
    }

    protected function validate($k){
        return in_array($k, $this->valid_attrs) || in_array($k, $this->valid_field_attrs);
    }

    protected function field_attrs(){
        $attrs = [];
        foreach ($this->attrs as $key => $value) {
            if ($this->validate($key)){
                $attrs[] = $this->attr($key, $value);
            }
        }
        return implode(' ', $attrs);
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

        if (isset($options['label_class'])){
            $this->label_class = $options['label_class'];
        }
    }

    public function setData($data){
        $this->data = $data;
    }

    public function label(){
        $label = $this->label;
        $id = $this->id();
        $required = $this->required ? $this->required_text : '';
        $class = $this->label_class ? $this->label_class : '';
        return "<label for='$id' class='$class'>$label $required</label>\n";
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

    public function data($old = null){
        return !is_null($old) ? $old : $this->data;
    }

    abstract public function widget($old);
}