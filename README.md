# Forms

Easy, framework agnostic HTML form rendering. This is meant to render a form in a way that is reproducible, reusable and consistent.

There is no (and there will not be any) validation whatsoever. It only deals with making valid HTML fields and forms.

There is no (and there will not be any) integration to any framework, it uses associative arrays or stdClasses for prepopulating forms (like when you edit a database entity).

The goal is to use one (or a few) generic template(s) to render all fields in a consistent way.

**Disclaimer: It does not have all HTML5 fields implemented and it does not do any validation of the attributes.**

## Installation

```BASH
composer require mdbottino/forms
```

## Usage

In order to use in a template (or plain PHP if you so desire) you have to subclass BaseForm and in the constructor do any needed configuration. The subclass' constructor **must** call the parent constructor and set the *fields* attribute. In the *fields* array you need to instantiate a specific field with name and label at a minimum.

Basic example:
```PHP
	use mdbottino\Forms\Base\BaseForm;
	use mdbottino\Forms\Fields\TextField;

	class BasicForm extends BaseForm {
	    public function __construct($src=null){
	        $this->fields = [
	            new TextField(
	                'desc',			# Name
	                'Description', 	# Label
	            ),
	        ];
	        parent::__construct($src);
	    }
	}
```

The use of the *$src* variable is optional, it allows to populate the form with data if given. This allows for adding or editing records easily

```PHP
	# It will render empty (with placeholders if given)
	$addForm = new BasicForm();


	# The folowing will render with the value given to each field.
	
	# Using arrays
	$array = ['desc' => 'some value'];
	$editFormArray = new BasicForm($array);

	# Using objects
	$obj = new \StdClass();
	$obj->desc = 'some other value';
	$editFormObject = new BasicForm($obj);
	
```

The keys/properties must match the names of the fields given upon creation.

The fields are accessed through the method *fields* which returns the array of fields.


The label is rendered through the method *label* of each field.
The widget is rendered through the method *widget* of each field.

The previous code would produce the following HTML:

```HTML
    <label for="id_desc">Description </label>
    <input id="id_desc" name="desc" type="text" value="">  
```


Using a blade template it could look like this
```Blade
    {!! $form->start() !!}
        @csrf
        @foreach ($form->fields() as $field)

            {!! $field->label() !!}
            {!! $field->widget(old($field->name())) !!}

        @endforeach

        <input value="Submit" type="submit" >
        <input value="Reset" type="reset" >

    {!! $form->end() !!}
	
```

It defaults to POST as method, no action and no enctype. If one of the fields is a FileField it will set the enctype to multipart/form-data. It can be overriden by using setAction, setMethod and setEnctype in the form.  

## Styling

Styling is as easy as it gets. The third and optional argument *options* supports a variety of keywords that changes the way the rendering behaves.

One of them is *attrs*, which equates to the attributes of the rendered field. If you give it a key named *class* it will display that value in the resulting HTML.


```PHP
	use mdbottino\Forms\Base\BaseForm;
	use mdbottino\Forms\Fields\TextField;
	use mdbottino\Forms\Fields\EmailField;

	class StyledForm extends BaseForm {
	    public function __construct($src=null){

	        $options = [
	            'attrs' => [
	                'class' => 'form-control', 
	            ],
	        ];

	        $this->fields = [
	            new TextField(
	                'desc',
	                'Description',
	                $options,
	            ),
	            new EmailField(
	                'email',
	                'E-mail address',
	                $options,
	            ),
	        ];

	        parent::__construct($src);
	    }
	}
```

The resulting HTML will be:

```HTML
    <label for="id_desc">Description </label>
    <input id="id_desc" name="desc" type="text" value="" class="form-control">

    <label for="id_email">E-mail address </label>
    <input id="id_email" name="email" type="email" value="" class="form-control">    
```

Styling using a blade template could look like this:
```Blade
    {!! $form->start() !!}
    	<div class='col-sm-6 m-auto'>
        @csrf
        @foreach ($form->fields() as $field)

	        <div class='form-group'>
	            {!! $field->label() !!}
	            {!! $field->widget(old($field->name())) !!}
	        </div>

        @endforeach
        </div>
        <div class="col-sm-6 m-auto">
        	<input value="Submit" type="submit" class="btn btn-primary mr-4" >
        	<input value="Reset" type="reset" class="btn btn-secondary" >
        </div>

    {!! $form->end() !!}
	
```

## Advanced usage

TODO

## Examples

TODO