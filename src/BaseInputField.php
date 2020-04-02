<?php

namespace mdbottino\Forms;

class BaseInputField extends BaseField {

    protected $type = null;

    protected $valid_field_attrs = ['value'];

    protected $template = "<input :attrs>";
}