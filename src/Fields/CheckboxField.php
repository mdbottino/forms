<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class CheckboxField extends BaseInputField {

    protected $valid_field_attrs = ['checked'];
    protected $template = "<input id=':id' name=':name' type=':type' :checked :attrs :required>";
    protected $type = 'checkbox';

    protected function vars($old=null){
        $data = $this->data($old);

        $vars = parent::vars($old);
        $vars[':checked'] = (boolean) $data ? 'checked' : '';

        return $vars;
    }
}