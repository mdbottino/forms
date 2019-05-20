<?php

namespace mdbottino\Forms\Base;

class BaseInputField extends BaseField {

    protected $type = null;

    public function widget($old=null){
        $name = $this->name;
        $id = $this->id();
        $type = $this->type();
        $data = !is_null($old) ? $old : $this->data;
        $attrs = $this->field_attrs();
        $required = $this->required ? 'required' : '';

        return "<input id='$id' name='$name' type='$type' value='$data' $attrs $required >\n";
    }
}