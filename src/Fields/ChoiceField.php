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

    protected $valid_field_attrs = ['selected'];

    protected $template = "<select :attrs>:options</select>";
    protected $option_template = "<option value=':value' :selected :custom>:desc</option>";



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
                if ($this->extra_value){
                    $this->valid_attrs[] = $this->extra_value;
                } 
            }
        } else {
            $this->choices = [];
        }

        $this->remove_unneeded_attrs();
    }

    protected function remove_unneeded_attrs(){
        $idx = array_search('type', $this->valid_attrs);
        array_splice($this->valid_attrs, $idx);
    }

    protected function make_custom_attr($el){
        $value = $el[$this->extra_value];
        return $this->attr($this->extra_key, $value);
    }

    protected function render_options($data=null){
        $options = [];
        if (!is_null($this->choice_default)){
            $options[] = $this->render($option_template, [
                ':value' => '',
                ':desc' => $this->choice_default,
            ]);
        }

        foreach ($this->choices as $choice) {
            $value = $choice[$this->choice_value];
            $custom = '';

            if (!is_null($this->extra_key)){
                $custom = $this->make_custom_attr($choice);
            }

            $options[] = $this->render($this->option_template, [
                ':value' => $value,
                ':desc' => $choice[$this->choice_desc],
                ':selected' => $value == $this->data ? 'selected' : '',
                ':custom' => $custom,
            ]);
        }

        return $options;
    }

    protected function vars($old=null){
        $vars = parent::vars($old);
        $options = $this->render_options($this->data($old));
        $vars[':options'] = implode($options);
        return $vars;
    }
}