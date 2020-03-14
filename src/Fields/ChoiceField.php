<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class ChoiceField extends BaseField {

    protected $type = 'select';
    protected $choices = null;
    protected $choice_value = null;
    protected $choice_desc = null;
    protected $extra_key = null;
    protected $extra_value = null;
    protected $choice_default = null;

    public function __construct($name, $label, array $options=null){

        parent::__construct($name, $label, $options);

        if (isset($options['choices'])){
            $choices = $options['choices'];
            $this->choices = isset($choices['data']) ? $choices['data'] : [];
            $this->choice_value = isset($choices['value']) ? $choices['value'] : 'id';
            $this->choice_desc = isset($choices['desc']) ? $choices['desc'] : 'desc';

            $this->choice_default = isset($choices['default']) ? $choices['default'] : null;

            if(isset($choices['extra'])){
                $extra = $choices['extra'];
                $this->extra_key =  isset($extra['key']) ? $extra['key'] : null;
                $this->extra_value =  isset($extra['value']) ? $extra['value'] : null;
            }
        } else {
            $this->choices = [];
        }
    }

    protected function make_custom_attr($el){
        $value = $el[$this->extra_value];
        return $this->attr($this->extra_key, $value);
    }

    public function widget($old=null){
        $name = $this->name;
        $id = $this->id();
        $type = $this->type();
        $data = $this->data($old);
        $attrs = $this->field_attrs();
        $required = $this->required ? 'required' : '';

        $html = ["<select id='$id' name='$name' $attrs $required >"];

        if (!is_null($this->choice_default)){
            $html[] = "<option value=''>{$this->choice_default}</option>";
        }

        $selected = '';
        $custom = '';

        foreach ($this->choices as $choice) {
            $value = $choice[$this->choice_value];
            $desc = $choice[$this->choice_desc];
            if ($value == $this->data){
                $selected = 'selected';
            }

            if (!is_null($this->extra_key)){
                $custom = $this->make_custom_attr($choice);
            }

            $html[] = "<option value='$value' $selected $custom >$desc</option>";
            $selected = '';
        }

        $html[] = '</select>';

        return implode($html);
    }
}