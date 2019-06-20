<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class HiddenField extends BaseInputField {

    protected $type = 'hidden';

    public function label(){
        return "";
    }
}