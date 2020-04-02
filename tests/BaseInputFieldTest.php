<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mdbottino\Forms\BaseInputField;

final class BaseInputFieldTest extends TestCase
{
    public function testEmpty(): void {
        $label = 'The Test';
        $name = 'the_test';
        $input = new BaseInputField($name, $label);
        $this->assertEquals($input->widget(), "<input name='$name' id='id_$name' type='' value=''>");
    }

    public function testRequired(): void {
        $label = 'The Test';
        $name = 'the_test';
        $options = [
            'required' => 'required'
        ];

        $input = new BaseInputField($name, $label, $options);
        $this->assertEquals($input->widget(), "<input name='$name' id='id_$name' type='' value='' required>");
    }

    public function testClass(): void {
        $label = 'The Test';
        $name = 'the_test';
        $class = 'form-control';
        $options = [
            'attrs' => [
                'class' => $class
            ],
        ];

        $input = new BaseInputField($name, $label, $options);
        $this->assertEquals($input->widget(), "<input class='$class' name='$name' id='id_$name' type='' value=''>");
    }

    public function testClassRequired(): void {
        $label = 'The Test';
        $name = 'the_test';
        $class = 'form-control';
        $options = [
            'attrs' => [
                'class' => $class,    
            ],
            'required' => 'required'
        ];

        $input = new BaseInputField($name, $label, $options);
        $this->assertEquals($input->widget(), "<input class='$class' name='$name' id='id_$name' type='' value='' required>");
    }

    public function testData(): void {
        $label = 'The Test';
        $name = 'the_test';
        $value = 110;

        $input = new BaseInputField($name, $label);
        $this->assertEquals($input->widget($value), "<input name='$name' id='id_$name' type='' value='$value'>");
    }

    public function testDataAttrs(): void {
        $label = 'The Test';
        $name = 'the_test';
        $class = 'form-control';
        $options = [
            'attrs' => [
                'class' => $class,
                'data-field' => 'extra'   ,
            ],
            'required' => 'required'
        ];

        $input = new BaseInputField($name, $label, $options);
        $this->assertEquals($input->widget(), "<input class='$class' data-field='extra' name='$name' id='id_$name' type='' value='' required>");
    }

}

