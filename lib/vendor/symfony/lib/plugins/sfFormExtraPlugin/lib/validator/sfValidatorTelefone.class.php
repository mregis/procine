<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorTelefone valida telefone.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorEmail.class.php 8835 2008-05-07 16:50:28Z nicolas $
 */
class sfValidatorTelefone extends sfValidatorBase
{
	/**
	 * Configures the current validator.
	 *
	 * O��es disponiveis :
	 *
	 *  * tipo:       Indica o tipo de inscri��o a ser validada
	 *  * time_output:       The format to use when returning a date with time (default to H:i:s)
	 *  * time_format_error: The date format to use when displaying an error for a bad_format error
	 *
	 * C�digo de erros dispon�veies
	 *
	 *  * valor_invalido
	 *
	 * @param array $options    Um vetor de op��es
	 * @param array $messages   Um vetor de mensagens
	 *
	 * @see sfValidatorBase
	 */
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('invalid', '"%value%" N�o � uma n�mero de telefone v�lido.');
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value)
	{
		$value = preg_replace("#\D#","",(string)$value);
		$clean = Valida::Telefone($value);
		if (false === $clean)
		{
			throw new sfValidatorError($this, 'invalid', array('value' => $value));
		}

		return $value;
	}
}
