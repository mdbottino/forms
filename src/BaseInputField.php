<?php

namespace mdbottino\Forms;

class BaseInputField extends BaseField {

    protected $type = null;

    public function widget($old=null){
        $name = $this->name;
        $id = $this->id();
        $type = $this->type();
        $data = $this->data($old);
        $attrs = $this->field_attrs();
        $required = $this->required ? 'required' : '';

        return "<input id='$id' name='$name' type='$type' value='$data' $attrs $required >\n";
    }
}