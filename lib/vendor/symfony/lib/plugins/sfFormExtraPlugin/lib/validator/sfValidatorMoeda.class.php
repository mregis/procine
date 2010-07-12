<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorMoeda valida número passado como Moeda no formato Brasileiro (integer ou float). Também converte para um float.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorMoeda.class.php 11476 2008-09-12 12:48:38Z fabien $
 */
class sfValidatorMoeda extends sfValidatorBase
{
	/**
	 * Configures the current validator.
	 *
	 * Available options:
	 *
	 *  * max: The maximum value allowed
	 *  * min: The minimum value allowed
	 *
	 * Available error codes:
	 *
	 *  * max
	 *  * min
	 *
	 * @param array $options   An array of options
	 * @param array $messages  An array of error messages
	 *
	 * @see sfValidatorBase
	 */
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('max', '"%value%" Deve ser menor que %max%.');
		$this->addMessage('min', '"%value%" Deve ser maior que %min%.');

		$this->addOption('min');
		$this->addOption('max');		
		$this->setMessage('invalid', '"%value%" Valor inválido.');
	}


	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value)
	{		
		// Será aceito apenas o formato ###.###,## com o opcional R$  
		if(!preg_match('#^(R\$\s*)?(\d{1,3}\.)*\d{1,3},\d{2}$#',$value)){
			throw new sfValidatorError($this, 'invalid', array('value' => $value));
		}
		// convertendo para float
		$clean  = preg_replace("#\D#","",$value)/100;				
		
		if (!is_float($clean) && ! is_int($clean))
		{
			throw new sfValidatorError($this, 'invalid', array('value' => $value));
		}

		if ($this->hasOption('max') && $clean > $this->getOption('max'))
		{
			throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => $this->getOption('max')));
		}

		if ($this->hasOption('min') && $clean < $this->getOption('min'))
		{
			throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => $this->getOption('min')));
		}
		return $clean;
	}
}
