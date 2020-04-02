<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mdbottino\Forms\Fields\TextareaField;

final class TextareaFieldTest extends TestCase
{
    public function testEmpty(): void {
        $label = 'The Test';
        $name = 'the_test';
        $input = new TextareaField($name, $label);
        $this->assertEquals($input->widget(), "<textarea name='$name' id='id_$name'></textarea>");
    }

    public function testData(): void {
        $label = 'The Test';
        $name = 'the_test';
        $value = 110;

        $input = new TextareaField($name, $label);
        $this->assertEquals($input->widget($value), "<textarea name='$name' id='id_$name'>$value</textarea>");
    }

}

