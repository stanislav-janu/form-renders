<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

use Nette,
	Nette\Forms\Controls;

class FormRender extends Nette\Forms\Rendering\DefaultFormRenderer
{
	public $isAjax = false;

	public $wrappers = [
		'form' => [
			'container' => NULL,
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
			'container' => NULL,
		],

		'pair' => [
			'container' => 'div class=form-group',
			'.required' => 'required',
			'.optional' => NULL,
			'.odd' => NULL,
			'.error' => 'has-error',
		],

		'control' => [
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
		],

		'label' => [
			'container' => 'div class="col-sm-4 control-label"',
			'suffix' => NULL,
			'requiredsuffix' => '',
		],

		'hidden' => [
			'container' => NULL,
		],
	];

	public function __construct(bool $isAjax = false)
	{
		$this->isAjax = $isAjax;
	}

	public function renderBegin()
	{
		if(empty($this->form->getElementPrototype()->getAttribute('class')))
			$this->form->getElementPrototype()->setAttribute('class', 'form-horizontal'. ($this->isAjax ? ' ajax' : ''));
		return parent::renderBegin();
	}

	/**
	 * Renders group of controls.
	 * @param  Nette\Forms\Container|Nette\Forms\ControlGroup
	 * @return string
	 */
	public function renderControls($parent)
	{
		if ($parent instanceof Controls\Button && empty($parent->control->getAttribute('class')))
		{
			$parent->setHtmlAttribute('class', 'btn btn-default');
		}
		elseif ($parent instanceof Controls\TextBase || $parent instanceof Controls\SelectBox || $parent instanceof Controls\MultiSelectBox)
		{
			$parent->setHtmlAttribute('class', 'form-control');
			if($parent instanceof Controls\TextBase)
			{
				$type = $parent->getControlPrototype()->getAttribute('type');
				if($type == 'datetime')
				{
					$parent->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD HH:mm"}');
				}
				elseif($type == 'date')
				{
					$parent->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD"}');
				}
				elseif($type == 'time')
				{
					$parent->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "HH:mm"}');
				}
			}
		}
		elseif ($parent instanceof Controls\Checkbox || $parent instanceof Controls\CheckboxList || $parent instanceof Controls\RadioList)
		{
			$parent->getSeparatorPrototype()->setName('div')->setAttribute('class', $parent->getControlPrototype()->type);
		}

		return parent::renderControls($parent);
	}
}