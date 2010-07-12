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
	 * Oções disponiveis :
	 *
	 *  * tipo:       Indica o tipo de inscrição a ser validada
	 *  * time_output:       The format to use when returning a date with time (default to H:i:s)
	 *  * time_format_error: The date format to use when displaying an error for a bad_format error
	 *
	 * Código de erros disponíveies
	 *
	 *  * valor_invalido
	 *
	 * @param array $options    Um vetor de opções
	 * @param array $messages   Um vetor de mensagens
	 *
	 * @see sfValidatorBase
	 */
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('invalid', '"%value%" Não é uma número de telefone válido.');
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
