<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class TextareaField extends BaseField {

    protected $type = 'textarea';

    public function widget($old=null){
        $name = $this->name;
        $id = $this->id();
        $type = $this->type();
        $data = $this->data($old);
        $attrs = $this->field_attrs();
        $required = $this->required ? 'required' : '';

        return "<textarea id='$id' name='$name' $attrs $required >$data</textarea>\n";
    }
}