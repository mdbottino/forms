<?php

namespace mdbottino\Forms;

class BaseInputField extends BaseField {

    protected $type = null;

    protected $template = "<input id=':id' name=':name' type=':type' value=':data' :attrs :required >";
}