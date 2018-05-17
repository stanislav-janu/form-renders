<?php declare(strict_types=1);

namespace JCode;

use Nette,
	Nette\Forms\Controls;

class FormRender extends Nette\Forms\Rendering\DefaultFormRenderer
{
	public $isAjax = false;

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
			'container' => 'div class=col-sm-8',
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
			'container' => 'div class="col-sm-4 control-label"',
			'suffix' => NULL,
			'requiredsuffix' => '',
		),

		'hidden' => array(
			'container' => NULL,
		),
	);

	public function __construct(bool $isAjax = false)
	{
		$this->isAjax = $isAjax;
	}

	public function render(Nette\Forms\Form $form, $mode = NULL)
	{
		$form->getElementPrototype()->class('form-horizontal'. ($this->isAjax ? ' ajax' : ''));
		foreach ($form->getControls() as $control)
		{
			if ($control instanceof Controls\Button)
			{
				$control->setAttribute('class', empty($usedPrimary) ? 'button button-yellow' : 'button');
				$usedPrimary = TRUE;

			}
			elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox)
			{
				$control->setAttribute('class', 'form-control');

			}
			elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList)
			{
				$control->getSeparatorPrototype()->setName('div')->class($control->getControlPrototype()->type);
			}
		}
		return parent::render($form, $mode);
	}
}