<?php declare(strict_types=1);

namespace JCode;

use Nette,
	Nette\Forms\Controls;

class BootstrapTabbedFormRender extends Nette\Forms\Rendering\DefaultFormRenderer
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

	public function __construct(bool $isAjax = false)
	{
		$this->isAjax = $isAjax;
	}

	public function render(Nette\Forms\Form $form, $mode = NULL)
	{
		$form->getElementPrototype()->class('tab-content'. ($this->isAjax ? ' ajax' : ''));
		foreach ($form->getControls() as $control)
		{
			if ($control instanceof Controls\Button)
			{
				$control->setAttribute('class', empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
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