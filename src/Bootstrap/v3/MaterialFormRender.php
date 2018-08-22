<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

class MaterialFormRender extends FormRender
{
	public $wrappers = array(
		'form' => array(
			'container' => NULL,
		),

		'error' => array(
			'container' => 'div class="alert alert-danger" role=alert',
			'item' => 'p',
		),

		'group' => array(
			'container' => 'fieldset',
			'label' => 'legend',
			'description' => 'p',
		),

		'controls' => array(
			'container' => NULL,
		),

		'pair' => array(
			'container' => 'div class=form-group',
			'.required' => 'required',
			'.optional' => NULL,
			'.odd' => NULL,
			'.error' => 'has-error',
		),

		'control' => array(
			'container' => 'div class=col-sm-12',
			'.odd' => NULL,

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
		),

		'label' => array(
			'container' => 'div class="col-sm-12 control-label" style="text-align: left"',
			'suffix' => NULL,
			'requiredsuffix' => '',
		),

		'hidden' => array(
			'container' => NULL,
		),
	);
}