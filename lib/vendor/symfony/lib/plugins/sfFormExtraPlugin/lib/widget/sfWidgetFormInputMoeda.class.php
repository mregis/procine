<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInputMoeda represents an HTML input tag.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormInputMoeda.class.php 9046 2008-05-19 08:13:51Z FabianLange $
 */
class sfWidgetFormInputMoeda extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type (text by default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('type', 'text');
    $this->setOption('is_hidden', false);
    $this->setAttribute('maxlength',20);
    $this->setAttribute('size',21);
    $this->setAttribute('onkeypress','return soNums(event,this,\'moeda\');');
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {  	
	$attributes['style']=';text-align:right';
	$attributes['tipo']='moeda';
	if(!is_string($value)){
		$value =Mascaras::_number_format($value); 
	}

  	return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' =>$value), $attributes));
  }
}
