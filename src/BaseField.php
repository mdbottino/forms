<?php

namespace mdbottino\Forms;

class BaseField {

    protected $name;
    protected $label;
    protected $label_class = null;
    protected $data;
    protected $attrs = [];
    protected $type;
    protected $required = false;
    protected $required_text = null;

    protected $template = '';
    protected $label_template = "<label for=':id' class=':class'>:text :required</label>";
    protected $description_template = "<small>:description</small>";

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
        $value = htmlspecialchars((string) $v);
        return "$k='$value'";
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

    protected function render($template, $vars){
        return strtr($template, $vars);
    }

    protected function vars($old=null){
        return [
            ':name' => $this->name(),
            ':id' => $this->id(),
            ':type' => $this->type(),
            ':data' => $this->data($old),
            ':attrs' => $this->field_attrs(),
            ':required' => $this->required ? 'required' : '',
        ];
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

        if (isset($options['description'])){
            $this->description = $options['description'];
        }
    }

    public function setData($data){
        $this->data = $data;
    }

    public function id(){
        return "id_" . $this->name();
    }

    public function type(){
        return $this->type;
    }

    public function name(){
        return htmlspecialchars($this->name);
    }

    public function data($old = null){
        return !is_null($old) ? $old : $this->data;
    } 

    public function label(){
        $vars = [
            ':text' => $this->label,
            ':id' => $this->id(),
            ':required' => $this->required ? $this->required_text : '',
            ':class' => $this->label_class ? htmlspecialchars($this->label_class) : '',
        ];
        return $this->render(
            $this->label_template,
            $vars
        );
    }


    public function widget($old=null){
        return $this->render($this->template, $this->vars($old));
    }

    public function description(){
        return $this->render(
            $this->description_template, 
            [':description' => htmlspecialchars($this->description)]
        );
    }

}