<?php declare(strict_types=1);

namespace JCode;

use Nette,
	Nette\Forms\Controls;

class MaterialFormRender extends Nette\Forms\Rendering\DefaultFormRenderer
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

	public function render(Nette\Forms\Form $form, $mode = NULL)
	{
		$form->getElementPrototype()->class('form-horizontal');
		foreach ($form->getControls() as $control)
		{
			if ($control instanceof Controls\Button)
			{
				$control->setAttribute('class', empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
				$usedPrimary = TRUE;

			}
			elseif ($control instanceof Controls\TextBase)
			{
				$control->setAttribute('class', 'form-control');
				if($control instanceof Controls\TextBase)
				{
					$type = $control->getControlPrototype()->getAttribute('type');
					if($type == 'datetime')
					{
						$control->setAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD HH:mm"}');
					}
					elseif($type == 'date')
					{
						$control->setAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD"}');
					}
					elseif($type == 'time')
					{
						$control->setAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "HH:mm"}');
					}
				}
			}
			elseif ($control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox)
			{
				$control->setAttribute('class', 'selectpicker');
			}
			elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList)
			{
				$control->getSeparatorPrototype()->setName('div')->class($control->getControlPrototype()->type);
			}
		}
		return parent::render($form, $mode);
	}
}