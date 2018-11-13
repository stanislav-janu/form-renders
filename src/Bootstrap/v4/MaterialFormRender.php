<?php declare(strict_types=1);

namespace JCode\FormRenders\Bootstrap\v4;

use Nette;

/**
 * Class MaterialFormRender
 * @package JCode\FormRenders\Bootstrap\v4
 */
class MaterialFormRender extends FormRender
{
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
			'label' => 'p class="h3 modal-header"',
			'description' => 'p class="pl-3 lead"',
		],

		'controls' => [
			'container' => null,
		],

		'pair' => [
			'container' => 'div class="row"',
			'.required' => null,
			'.optional' => null,
			'.odd' => null,
			'.error' => 'has-danger',
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
			'container' => null,
			'suffix' => null,
			'requiredsuffix' => null,
		],

		'hidden' => [
			'container' => null,
		],
	];

	/** @var string */
	public $labelClass = 'col-form-label col-md-3 text-md-right col-sm-12';

	/**
	 * @param \Nette\Forms\IControl $control
	 *
	 * @return \Nette\Utils\Html
	 */
	public function renderControl(Nette\Forms\IControl $control): Nette\Utils\Html
	{
		$body = $this->getWrapper('control container');
		if ($this->counter % 2) {
			$body->class($this->getValue('control .odd'), true);
		}

		$description = $control->getOption('description');
		if ($description instanceof Nette\Utils\IHtmlString) {
			$description = ' ' . $description;

		} elseif ($description != null) { // intentionally ==
			if ($control instanceof Nette\Forms\Controls\BaseControl) {
				$description = $control->translate($description);
			}
			$description = ' ' . $this->getWrapper('control description')->setText($description);

		} else {
			$description = '';
		}

		if ($control->isRequired()) {
			$description = $this->getValue('control requiredsuffix') . $description;
		}

		$control->setOption('rendered', true);

		// Is this an instance of a RadioList or Checkbox?
		if ($control instanceof Nette\Forms\Controls\CheckboxList || $control instanceof Nette\Forms\Controls\RadioList)
		{
			$el = Nette\Utils\Html::el();
			foreach($control->getItems() as $key => $item)
				$el->addHtml($control->getLabelPart($key)->addHtml($control->getControlPart($key)->setAttribute('class', 'form-check-input'))->addHtml('<span class="form-check-sign"><span class="check"></span></span>'));
		}
		else if ($control instanceof Nette\Forms\Controls\Checkbox)
		{
			$el = Nette\Utils\Html::el('div', ['class' => 'form-check']);
			$el->addHtml($control->getLabelPart()->addHtml($control->getControlPart()->setAttribute('class', 'form-check-input'))->addHtml('<span class="form-check-sign"><span class="check"></span></span>'));
		}
		else
		{
			$el = $control->getControl();
		}

		if ($el instanceof Nette\Utils\Html && $el->getName() === 'input') {
			$el->class($this->getValue("control .$el->type"), true);
		}
		return $body->setHtml($el . $description . $this->renderErrors($control));
	}
}
