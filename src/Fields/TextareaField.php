<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseField;

class TextareaField extends BaseField {

    protected $type = 'textarea';
    protected $template = "<textarea id=':id' name=':name' :attrs :required >:data</textarea>";
}