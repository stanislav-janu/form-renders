<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

class FullWightFormRender extends FormRender
{
	public $wrappers = [
		'form' => [
			'container' => null,
		],

		'error' => [
			'container' => 'div class="alert alert-danger" role=alert',
			'item' => 'p',
		],

		'group' => [
			'container' => 'fieldset',
			'label' => 'legend',
			'description' => 'p',
		],

		'controls' => [
			'container' => null,
		],

		'pair' => [
			'container' => 'div class=form-group',
			'.required' => 'required',
			'.optional' => null,
			'.odd' => null,
			'.error' => 'has-error',
		],

		'control' => [
			'container' => 'div class=col-sm-12',
			'.odd' => null,

			'description' => 'span class=help-block',
			'requiredsuffix' => '',
			'errorcontainer' => 'span class=help-block',
			'erroritem' => '',

			'.required' => 'required',
			'.text' => 'text',
			'.password' => 'text',
			'.file' => 'text',
			'.submit' => 'button',
			'.image' => 'imagebutton',
			'.button' => 'button',
		],

		'label' => [
			'container' => 'div class="col-sm-12 control-label" style="text-align: left"',
			'suffix' => null,
			'requiredsuffix' => '',
		],

		'hidden' => [
			'container' => null,
		],
	];
}