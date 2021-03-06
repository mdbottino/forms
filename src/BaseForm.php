<?php

namespace mdbottino\Forms;

class BaseForm {

    /* Valid Enctypes */
    const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTIPART = 'multipart/form-data';
    const ENCTYPE_PLAIN = 'text/plain';

    const ENCTYPES = [
        self::ENCTYPE_DEFAULT,
        self::ENCTYPE_MULTIPART,
        self::ENCTYPE_PLAIN,
    ];

    /* Valid Methods */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    const METHODS = [
        self::METHOD_GET,
        self::METHOD_POST,
    ];

    /*
     *  Each entry should have the following format:
     *   
     *  TypeOfWidget(
     *      $name (string),
     *      $label (string),
     *      $options (array)
     *  )
     */
    protected $fields = [];

    /*
     *  StdClass instance or associative array 
     */
    protected $src;

    /*
     *  Only used for layout positioning
     */
    protected $length = 0;

    protected $enctype = null;

    protected $method = self::METHOD_POST;

    protected $action = null;

    protected function getValue($src, $key){
        if (gettype($src) === 'object'){
            return isset($src->$key) ? $src->$key : null;
        } else {
            return isset($src[$key]) ? $src[$key] : null;
        }
    }

    protected function populate(){
        if (!is_null($this->src)){
            foreach ($this->fields as $field){
                $value = $this->getValue($this->src, $field->name());
                if($value){
                    $field->setData($value);                
                }
            }            
        }
    }

    protected function enctype(){
        foreach ($this->fields as $field){
            if($field->type() === 'file'){
                $this->enctype = self::ENCTYPE_MULTIPART;
                break;               
            }
        }        

        if (!is_null($this->enctype)){
            if ($this->enctype !== self::ENCTYPE_DEFAULT){
                return "enctype='".$this->enctype."'";
            }
        }
        return '';
    }

    protected function action(){
        if(!is_null($this->action)){
            return "action='".$this->action ."'";
        }
        return '';
    }

    protected function method(){      
        return "method='".$this->method."'";
    }

    public function __construct($src=null) {
        $this->length = count($this->fields);
        $this->src = $src;
        if (!is_null($src)){
           $this->populate(); 
        }
    }

    public function setLayoutAwareness($step=2){
        $len = 0;
        foreach ($this->fields as $field){
            if ($field->type() === 'textarea'){
                $len += $step;
            } elseif ($field->type() === 'hidden') {
                continue;
            } else {
                $len++;
            }
        }
        $this->length = $len;
    }

    public function setMethod($method){
        $method = strtoupper($method);
        if (in_array($method, self::METHODS)){
            $this->method = $method;
            return true;
        }
        return false;
    }

    public function setAction($action){
        $this->action = htmlspecialchars($action);
        return true;
    }

    public function setEnctype($enctype){
        $enctype = strtolower($enctype);
        if (in_array($enctype, self::ENCTYPES)){
            $this->enctype = $enctype;
            return true;
        }
        return false;
    }

    public function fields(){
        return $this->fields;
    }

    public function addField(BaseField $field){
        array_push($this->fields, $field);
        $this->length += 1;
    }

    public function countFieldsForLayout(){
        return $this->length;
    }

    public function start(){
        $action = $this->action();
        $method = $this->method();
        $enctype = $this->enctype();
        return "<form $action $method $enctype>";
    }

    public function end(){
        return '</form>';
    }
}