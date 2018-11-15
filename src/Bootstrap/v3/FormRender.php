<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v3;

use Nette;

/**
 * Class FormRender
 * @package JCode\FormRenders\Bootstrap\v3
 */
class FormRender extends Nette\Forms\Rendering\DefaultFormRenderer
{
	/** @var bool */
	public $isAjax = false;

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
			'container' => 'div class=col-sm-8',
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
			'container' => 'div class="col-sm-4 control-label"',
			'suffix' => null,
			'requiredsuffix' => '',
		],

		'hidden' => [
			'container' => null,
		],
	];

	/**
	 * FormRender constructor.
	 *
	 * @param bool $isAjax
	 */
	public function __construct(bool $isAjax = false)
	{
		$this->isAjax = $isAjax;
	}

	/**
	 * @return string
	 */
	public function renderBegin()
	{
		if(empty($this->form->getElementPrototype()->getAttribute('class')))
			$this->form->getElementPrototype()->setAttribute('class', 'form-horizontal'. ($this->isAjax ? ' ajax' : ''));
		return parent::renderBegin();
	}


	/**
	 * @param array $controls
	 * @return string
	 */
	public function renderPairMulti(array $controls): string
	{
		foreach ($controls as $control)
		{
			if ($control instanceof Nette\Forms\Controls\Button)
			{
				if ($control->controlPrototype->getAttribute('class') === null || (is_array($control->controlPrototype->getAttribute('class')) && !Nette\Utils\Strings::contains(implode(' ', array_keys($control->controlPrototype->getAttribute('class'))), 'btn btn-')))
					$control->controlPrototype->setAttribute('class', (empty($primary) ? 'btn btn-primary' : 'btn btn-secondary'));

				$primary = true;
			}
		}

		return parent::renderPairMulti($controls);
	}

	/**
	 * @param Nette\Forms\IControl $control
	 * @return Nette\Utils\Html
	 */
	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\CheckboxList)
		{
			$control->controlPrototype->setAttribute('class', 'checkbox');

			if ($control instanceof Nette\Forms\Controls\CheckboxList)
				$control->separatorPrototype->setName('div')->setAttribute('class', 'checkbox');
		}
		elseif ($control instanceof Nette\Forms\Controls\RadioList)
		{
			$control->containerPrototype->setName('div')->setAttribute('class', 'radio');
		}
		else
		{
			$type = $control->getControlPrototype()->getAttribute('type');
			if($type == 'datetime')
				$control->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD HH:mm"}');
			elseif($type == 'date')
				$control->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "YYYY-MM-DD"}');
			elseif($type == 'time')
				$control->setHtmlAttribute('data-onload-datetimepicker', '{"locale": "cs", "format": "HH:mm"}');

			if ($control->hasErrors())
				$control->controlPrototype->setAttribute('class', 'is-invalid');

			$control->controlPrototype->setAttribute('class', 'form-control');
		}

		$parent = parent::renderControl($control);

		// addons
		if ($control instanceof Nette\Forms\Controls\TextInput)
		{
			$leftAddon = $control->getOption('left-addon');
			$rightAddon = $control->getOption('right-addon');

			if ($leftAddon !== null || $rightAddon !== null)
			{
				$children = $parent->getChildren();
				$parent->removeChildren();

				$container = Nette\Utils\Html::el('div')->setAttribute('class', 'input-group');

				if ($leftAddon !== null)
				{
					if (!is_array($leftAddon))
						$leftAddon = [$leftAddon];

					$div = Nette\Utils\Html::el('div')->setAttribute('class', 'input-group-prepend');

					foreach ($leftAddon as $v)
						$div->insert(null, Nette\Utils\Html::el('span')->setAttribute('class', 'input-group-text')->setText($v));

					$container->insert(null, $div);
				}

				foreach ($children as $child)
				{
					$foo = Nette\Utils\Strings::after($child, $control->getControlPart()->render());

					if ($foo !== false)
					{
						$container->insert(null, $control->getControlPart()->render());
						$description = $foo;

					}
					else
					{
						$container->insert(null, $child);
					}
				}

				if ($rightAddon !== null)
				{
					if (!is_array($rightAddon))
						$rightAddon = [$rightAddon];

					$div = Nette\Utils\Html::el('div')->setAttribute('class', 'input-group-append');

					foreach ($rightAddon as $v)
						$div->insert(null, Nette\Utils\Html::el('span')->setAttribute('class', 'input-group-text')->setText($v));

					$container->insert(null, $div);
				}

				$parent->insert(null, $container);

				if (!empty($description))
					$parent->insert(null, $description);
			}
		}

		return $parent;
	}
}
