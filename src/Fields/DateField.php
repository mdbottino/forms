<?php

namespace mdbottino\Forms\Fields;

use mdbottino\Forms\BaseInputField;

class DateField extends BaseInputField {

    const DATE_FORMAT = 'Y-m-d';
    protected $type = 'date';

    public function data($old = null){
        $value = !is_null($old) ? $old : $this->data;

        $timestamp = strtotime($value);

        if ($timestamp === false){
            return '';
        } else {
            return date($this::DATE_FORMAT , $timestamp);
        }
    }
}