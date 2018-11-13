<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

/**
 * Class TabbedFormRender
 * @package JCode\FormRenders\Bootstrap\v3
 */
class TabbedFormRender extends FormRender
{
	/** @var array */
	public $wrappers = [
		'form' => [
			'container' => null,
		],

		'error' => [
			'container' => 'div class="alert alert-danger" role=alert',
			'item' => 'p',
		],

		'group' => [
			'container' => 'div role=tabpanel class="tab-pane"',
			'label' => 'h2',
			'description' => 'span class=language-code style="display:none"',
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
			'container' => null,
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
			'container' => null,
			'suffix' => null,
			'requiredsuffix' => '',
		],

		'hidden' => [
			'container' => null,
		],
	];

	/**
	 * @return string
	 */
	public function renderBegin()
	{
		$this->form->getElementPrototype()->setAttribute('class', 'tab-content'. ($this->isAjax ? ' ajax' : ''));
		return parent::renderBegin();
	}
}
