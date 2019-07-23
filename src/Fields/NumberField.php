<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class NumberField extends BaseInputField {

    protected $valid_field_attrs = ['step'];

    protected $type = 'number';
}