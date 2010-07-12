<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInputInscricao representa uma tag HTML input text com funcionalidades para inscrição (CNPJ, CPF, etc) .
 *
 * @package    autor_rem
 * @subpackage widget
 * @author     Marcos Regis <marcos@marcosregis.com>

 * @version    SVN: $Id: sfWidgetFormInput.class.php 9046 2008-05-19 08:13:51Z FabianLange $
 */
class sfWidgetFormInputTelefone extends sfWidgetFormInput
{

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * tipo: O Tipo da inscrição (CNPJ por default)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('size', 16);
    $this->addOption('tipo', 'tel');
	parent::configure();    
       
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
  	$tipo= $this->getOption('tipo');
  	$size = (int) $this->getOption('size');  	

  	$value = Mascaras::formataTelefone($value);  		  	
  	return parent::render($name,$value,array_merge(array("onkeypress"=>"return soNums(event,this,this.getAttribute('tipo'));",'tipo'=>$this->getOption('tipo'),'maxlength'=>14,'size'=>$size),$this->getAttributes()), $errors);
  }
}

