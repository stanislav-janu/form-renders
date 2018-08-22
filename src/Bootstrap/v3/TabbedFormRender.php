<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

class TabbedFormRender extends FormRender
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
			'container' => 'div role=tabpanel class="tab-pane"',
			'label' => 'h2',
			'description' => 'span class=language-code style="display:none"',
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
			'container' => NULL,
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
			'container' => NULL,
			'suffix' => NULL,
			'requiredsuffix' => '',
		),

		'hidden' => array(
			'container' => NULL,
		),
	);

	public function renderBegin()
	{
		$this->form->getElementPrototype()->setAttribute('class', 'tab-content'. ($this->isAjax ? ' ajax' : ''));
		return parent::renderBegin();
	}
}