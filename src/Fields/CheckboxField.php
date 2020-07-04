<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class CheckboxField extends BaseInputField {

    protected $valid_field_attrs = ['checked'];
    protected $type = 'checkbox';

    protected function vars($old=null){
        $data = $this->data($old);
        $this->attrs['checked'] = (boolean) $data ? 'checked' : '';

        return parent::vars($old);
    }
}