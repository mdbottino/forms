<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class CheckboxField extends BaseField {

    protected $valid_field_attrs = ['checked'];

    protected $type = 'checkbox';

    public function widget($old){
        $type = $this->type();
        $id = $this->id();
        $name = $this->name();
        $data = !is_null($old) ? $old : $this->data;
        $checked = (boolean) $data ? 'checked' : '';
        $attrs = $this->field_attrs();
        $required = $this->required ? 'required' : '';

        return "<input id='$id' name='$name' type='$type' $checked $attrs $required> \n";
    }
}