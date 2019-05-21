<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class HiddenField extends BaseField {

    protected $type = 'hidden';

    public function label(){
        return "";
    }

    public function widget($old){
        $type = $this->type();
        $id = $this->id();
        $name = $this->name();
        $data = !is_null($old) ? $old : $this->data;
        return "<input id='$id' name='$name' type='$type' value='$data'> \n";
    }
}