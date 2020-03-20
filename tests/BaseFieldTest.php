<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mdbottino\Forms\BaseField;
use mdbottino\Forms\Fields\TextField;
use mdbottino\Forms\Fields\HiddenField;
use mdbottino\Forms\Fields\TextareaField;

final class BaseFieldTest extends TestCase
{
    public function testEmpty(): void {
        $label = 'The Test';
        $name = 'the_test';

        $input = new BaseField($name, $label);
        $this->assertEquals($input->widget(), "");
        $this->assertEquals($input->label(), "<label for='id_$name' class=''>$label </label>");
    }

    public function testLabelClass(): void {
        $label = 'The Test';
        $name = 'the_test';
        $class = 'form-label';
        $options = [
            'label_class' => $class
        ];

        $input = new BaseField($name, $label, $options);
        $this->assertEquals($input->label(), "<label for='id_$name' class='$class'>$label </label>");
    }

    public function testLabelRequiredText(): void {
        $label = 'The Test';
        $name = 'the_test';
        $options = [
            'required' => 'required',
            'required_text' => '*'
        ];

        $input = new BaseField($name, $label, $options);
        $this->assertEquals($input->label(), "<label for='id_$name' class=''>$label *</label>");
    }
}