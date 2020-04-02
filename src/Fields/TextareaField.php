<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class TextareaField extends BaseField {

    protected $type = 'textarea';

    protected $omitted_field_attrs = ['type', 'value'];

    protected $template = "<textarea :attrs>:value</textarea>";

    protected function vars($old=null){
        $vars = parent::vars($old);

        return [
            ':attrs' => $this->field_attrs(),
            ':value' => $this->data($old),
        ];
    }
}