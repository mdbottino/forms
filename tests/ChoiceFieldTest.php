<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mdbottino\Forms\Fields\ChoiceField;

final class ChoiceFieldTest extends TestCase
{
    public function testEmpty(): void {
        $label = 'The Test';
        $name = 'the_test';
        $input = new ChoiceField($name, $label);
        $this->assertEquals($input->widget(), "<select name='$name' id='id_$name'></select>");
    }


    public function testWithSimpleData(): void {
        $label = 'The Test';
        $name = 'the_test';
        $input = new ChoiceField(
            $name,
            $label,
            [
                'choices' => [
                    'data' => [
                        ['id' => 'H', 'desc' => 'Hombre', 'extra' => 5,], 
                        ['id' => 'M', 'desc' => 'Mujer', 'extra' => 7,], 
                    ],
                ],
            ]

        );

        $this->assertEquals($input->widget(), "<select name='the_test' id='id_the_test'><option value='H'  >Hombre</option><option value='M'  >Mujer</option></select>");
    }
    
    public function testWithDefault(): void {
        $label = 'The Test';
        $name = 'the_test';
        $default = '-';
        $input = new ChoiceField(
            $name,
            $label,
            [
                'choices' => [
                    'data' => [
                        ['id' => 'H', 'desc' => 'Hombre', 'extra' => 5,], 
                        ['id' => 'M', 'desc' => 'Mujer', 'extra' => 7,], 
                    ],
                    'default' => $default
                ],
            ]

        );

        $this->assertEquals($input->widget(), "<select name='the_test' id='id_the_test'><option value=''  >$default</option><option value='H'  >Hombre</option><option value='M'  >Mujer</option></select>");
    }
   
    public function testWithSelected(): void {
        $label = 'The Test';
        $name = 'the_test';
        $input = new ChoiceField(
            $name,
            $label,
            [
                'choices' => [
                    'data' => [
                        ['id' => 'H', 'desc' => 'Hombre', 'extra' => 5,], 
                        ['id' => 'M', 'desc' => 'Mujer', 'extra' => 7,], 
                    ],
                ],
            ]

        );

        $this->assertEquals($input->widget('H'), "<select name='the_test' id='id_the_test'><option value='H' selected >Hombre</option><option value='M'  >Mujer</option></select>");
    }

}

