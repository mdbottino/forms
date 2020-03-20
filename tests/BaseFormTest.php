<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mdbottino\Forms\BaseForm;
use mdbottino\Forms\Fields\TextField;
use mdbottino\Forms\Fields\HiddenField;
use mdbottino\Forms\Fields\TextareaField;

final class BaseFormTest extends TestCase
{
    public function testEmptyForm(): void {
        $form = new BaseForm();
        $this->assertTrue($form !== null);
        $this->assertEquals(count($form->fields()), 0);
        $this->assertEquals($form->countFieldsForLayout(), 0);
    }

    public function testEmptyStart(): void {
        $form = new BaseForm();
        $this->assertEquals($form->start(), "<form  method='POST' >");
    }

    public function testGetMethodStart(): void {
        $form = new BaseForm();
        $ok = $form->setMethod('get');

        $this->assertTrue($ok);
        $this->assertEquals($form->start(), "<form  method='GET' >");
    }

    public function testMultipartFormDataEnctypeStart(): void {
        $form = new BaseForm();
        $ok = $form->setEnctype(BaseForm::ENCTYPE_MULTIPART);

        $this->assertTrue($ok);
        $this->assertEquals($form->start(), "<form  method='POST' enctype='".BaseForm::ENCTYPE_MULTIPART."'>");
    }

    public function testFakeEnctypeStart(): void {
        $form = new BaseForm();
        $ok = $form->setEnctype('fake/enctype');

        $this->assertFalse($ok);
        $this->assertEquals($form->start(), "<form  method='POST' >");
    }

    public function testDefaultEnctypeStart(): void {
        $form = new BaseForm();
        $ok = $form->setEnctype(BaseForm::ENCTYPE_DEFAULT);

        $this->assertTrue($ok);
        $this->assertEquals($form->start(), "<form  method='POST' >");
    }

    public function testActionStart(): void {
        $form = new BaseForm();
        $endpoint = '/fake/endpoint';
        $ok = $form->setAction($endpoint);

        $this->assertTrue($ok);
        $this->assertEquals($form->start(), "<form action='$endpoint' method='POST' >");
    }

    public function testMaliciousActionStart(): void {
        $form = new BaseForm();
        $endpoint = "'/fake/endpoint'> <script>alert('gotcha');</script> </form>< form'";
        $ok = $form->setAction($endpoint);

        $this->assertTrue($ok);
        $this->assertEquals($form->start(), "<form action='".htmlspecialchars($endpoint)."' method='POST' >");
    }

    public function testActionEnctypeMethodStart(): void {
        $form = new BaseForm();
        $endpoint = '/fake/endpoint';

        $action = $form->setAction($endpoint);
        $enctype = $form->setEnctype(BaseForm::ENCTYPE_MULTIPART);
        $method = $form->setMethod('get');
        
        $this->assertTrue($action && $enctype && $method);
        $this->assertEquals($form->start(), "<form action='$endpoint' method='GET' enctype='".BaseForm::ENCTYPE_MULTIPART."'>");
    }

    public function testEnd(): void {
        $form = new BaseForm();
        $this->assertEquals($form->end(),'</form>');
    }

    public function testFormWithFields(): void {
        $form = new BaseForm();
        $form->addField(new TextField('text', 'Text'));
        $form->addField(new TextareaField('area', 'Area'));
        $form->addField(new HiddenField('hidden', 'Hidden'));

        $this->assertEquals(count($form->fields()), 3);
        $this->assertEquals($form->countFieldsForLayout(), 3);
    }

    public function testFormWithFieldsLayoutAwarenessHidden(): void {
        $form = new BaseForm();
        $form->addField(new TextField('text', 'Text'));
        $form->addField(new HiddenField('hidden', 'Hidden'));
        $form->setLayoutAwareness();

        $this->assertEquals(count($form->fields()), 2);
        $this->assertEquals($form->countFieldsForLayout(), 1);
    }

    public function testFormWithFieldsLayoutAwarenessTextArea(): void {
        $form = new BaseForm();
        $form->addField(new TextField('text', 'Text'));
        $form->addField(new TextareaField('area', 'Area'));
        $form->setLayoutAwareness();

        $this->assertEquals(count($form->fields()), 2);
        $this->assertEquals($form->countFieldsForLayout(), 3);
    }
}