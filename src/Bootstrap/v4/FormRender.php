<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v4;

use Nette;


/**
 * Class FormRender
 *
 * @original https://github.com/aleswita/FormRenderer
 *
 * @package JCode\FormRenders\Bootstrap\v4
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
			'container' => 'div class="row mb-3"',
			'item' => 'div class="col-12 alert alert-danger"',
		],

		'group' => [
			'container' => null,
			'label' => 'p class="h5 pb-1 border-bottom"',
			'description' => 'p class="text-muted"',
		],

		'controls' => [
			'container' => null,
		],

		'pair' => [
			'container' => 'div class="form-group row"',
			'.required' => null,
			'.optional' => null,
			'.odd' => null,
			'.error' => null,
		],

		'control' => [
			'container' => 'div class="col-md-9 col-sm-12"',
			'.odd' => null,

			'description' => 'small class="form-text text-muted"',
			'requiredsuffix' => null,
			'errorcontainer' => 'div class="invalid-feedback"',
			'erroritem' => null,

			'.required' => null,
			'.text' => null,
			'.password' => null,
			'.file' => null,
			'.email' => null,
			'.number' => null,
			'.submit' => null,
			'.image' => null,
			'.button' => null,
		],

		'label' => [
			'container' => 'div class="col-md-3 text-md-right col-sm-12"',
			'suffix' => null,
			'requiredsuffix' => '*',
		],

		'hidden' => [
			'container' => null,
		],
	];

	/** @var string */
	public $labelClass = 'col-form-label';

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
	public function renderBegin() : string
	{
		if (empty($this->form->getElementPrototype()->getAttribute('class'))) {
			$this->form->getElementPrototype()->setAttribute('class', 'form-horizontal'.($this->isAjax ? ' ajax' : ''));
		}

		return parent::renderBegin();
	}

	/**
	 * @param Nette\Forms\IControl $control
	 * @param bool                 $own
	 *
	 * @return string
	 */
	public function renderErrors(Nette\Forms\IControl $control = null, bool $own = true) : string
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\RadioList || $control instanceof Nette\Forms\Controls\UploadControl) {
			$temp = $this->wrappers['control']['errorcontainer'];
			$this->wrappers['control']['errorcontainer'] = $this->wrappers['control']['errorcontainer'].' style="display: block"';
		}

		$parent = parent::renderErrors($control, $own);

		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\RadioList || $control instanceof Nette\Forms\Controls\UploadControl) {
			$this->wrappers['control']['errorcontainer'] = $temp;
		}

		return $parent;
	}

	/**
	 * @param array $controls
	 *
	 * @return string
	 */
	public function renderPairMulti(array $controls) : string
	{
		foreach ($controls as $control) {
			if ($control instanceof Nette\Forms\Controls\Button) {
				if ($control->controlPrototype->getAttribute('class') === null || (is_array($control->controlPrototype->getAttribute('class')) && !Nette\Utils\Strings::contains(implode(' ', array_keys($control->controlPrototype->getAttribute('class'))), 'btn btn-'))) {
					$control->controlPrototype->setAttribute('class', (empty($primary) ? 'btn btn-outline-primary' : 'btn btn-outline-secondary'));
				}

				$primary = true;
			}
		}

		return parent::renderPairMulti($controls);
	}

	/**
	 * @param Nette\Forms\IControl $control
	 *
	 * @return Nette\Utils\Html
	 */
	public function renderLabel(Nette\Forms\IControl $control) : Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\CheckboxList) {
			$control->labelPrototype->setAttribute('class', 'form-check-label');
		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->labelPrototype->setAttribute('class', 'form-check-label');
		} else {
			$control->labelPrototype->setAttribute('class', $this->labelClass);
		}

		$parent = parent::renderLabel($control);

		return $parent;
	}

	/**
	 * @param Nette\Forms\IControl $control
	 *
	 * @return Nette\Utils\Html
	 */
	public function renderControl(Nette\Forms\IControl $control) : Nette\Utils\Html
	{
		if ($control instanceof Nette\Forms\Controls\Checkbox || $control instanceof Nette\Forms\Controls\CheckboxList) {
			$control->controlPrototype->setAttribute('class', 'form-check-input');

			if ($control instanceof Nette\Forms\Controls\CheckboxList) {
				$control->separatorPrototype->setName('div')->setAttribute('class', 'form-check form-check-inline');
			}
		} elseif ($control instanceof Nette\Forms\Controls\RadioList) {
			$control->containerPrototype->setName('div')->setAttribute('class', 'form-check');
			$control->itemLabelPrototype->setAttribute('class', 'form-check-label');
			$control->controlPrototype->setAttribute('class', 'form-check-input');
		} elseif ($control instanceof Nette\Forms\Controls\UploadControl) {
			$control->controlPrototype->setAttribute('class', 'form-control-file');
		} else {
			if ($control->hasErrors()) {
				$control->controlPrototype->setAttribute('class', 'is-invalid');
			}

			$control->controlPrototype->setAttribute('class', 'form-control');
		}

		$parent = parent::renderControl($control);

		// addons
		if ($control instanceof Nette\Forms\Controls\TextInput) {
			$leftAddon = $control->getOption('left-addon');
			$rightAddon = $control->getOption('right-addon');

			if ($leftAddon !== null || $rightAddon !== null) {
				$children = $parent->getChildren();
				$parent->removeChildren();

				$container = Nette\Utils\Html::el('div')->setAttribute('class', 'input-group');

				if ($leftAddon !== null) {
					if (!is_array($leftAddon)) {
						$leftAddon = [$leftAddon];
					}

					$div = Nette\Utils\Html::el('div')
						->setAttribute('class', 'input-group-prepend');

					foreach ($leftAddon as $v) {
						$div->insert(null, Nette\Utils\Html::el('span')
							->setAttribute('class', 'input-group-text')
							->setText($v));
					}

					$container->insert(null, $div);
				}

				foreach ($children as $child) {
					$foo = Nette\Utils\Strings::after($child, $control->getControlPart()->render());

					if ($foo !== false) {
						$container->insert(null, $control->getControlPart()->render());
						$description = $foo;
					} else {
						$container->insert(null, $child);
					}
				}

				if ($rightAddon !== null) {
					if (!is_array($rightAddon)) {
						$rightAddon = [$rightAddon];
					}

					$div = Nette\Utils\Html::el('div')->setAttribute('class', 'input-group-append');

					foreach ($rightAddon as $v) {
						$div->insert(null, Nette\Utils\Html::el('span')
							->setAttribute('class', 'input-group-text')
							->setText($v));
					}

					$container->insert(null, $div);
				}

				$parent->insert(null, $container);

				if (!empty($description)) {
					$parent->insert(null, $description);
				}
			}
		}

		return $parent;
	}
}
