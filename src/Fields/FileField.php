<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class FileField extends BaseInputField {

    protected $valid_field_attrs = ['accept'];

    protected $type = 'file';
}