FormRenders
===========

Bootstrap 3 & 4 renders for nette/forms.

Installation
---

	$ composer require stanislav-janu/form-renders
	
Using
---

	use JCode\FormRenders\Bootstrap\v4\FormRender;
	
	$form = new Form;
	$form->setRenderer(new FormRender); // Normal form

or

	$form->setRenderer(new FormRender(true)); // Ajax form