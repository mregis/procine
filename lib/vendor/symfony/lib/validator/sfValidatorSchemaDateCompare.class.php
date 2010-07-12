<?php

/*
 * This file is part of the autorizacao package.
 * (c) Marcos Regis <marcos.regis@finnet.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorSchemaDateCompare compares several values from an array.
 *
 * @package    autorizacao
 * @subpackage validator
 * @author     Marcos Regis <marcos.regis@finnet.com.br>
 * @version    1.0
 */
class sfValidatorSchemaDateCompare extends sfValidatorSchema
{
	const EQUAL              = '==';
	const NOT_EQUAL          = '!=';
	const LESS_THAN          = '<';
	const LESS_THAN_EQUAL    = '<=';
	const GREATER_THAN       = '>';
	const GREATER_THAN_EQUAL = '>=';

	/**
	 * Construtor.
	 *
	 * Para a lista de opções e mensagens ver sfValidatorSchema
	 *
	 *
	 * @see sfValidatorSchemaCompare
	 */
	public function __construct($leftField, $operator, $rightField, $options = array(), $messages = array())
	{
		$this->addOption('left_field', $leftField);
		$this->addOption('operator', $operator);
		$this->addOption('right_field', $rightField);

		$this->addOption('throw_global_error', false);

		parent::__construct(null, $options, $messages);
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($values)
	{
		if (is_null($values))
		{
			$values = array();
		}

		if (!is_array($values))
		{
			throw new InvalidArgumentException('Você deve passar um vetor de parâmetros para o método clean()');
		}

		$leftValue  = isset($values[$this->getOption('left_field')]) ? $values[$this->getOption('left_field')] : null;
		$rightValue = isset($values[$this->getOption('right_field')]) ? $values[$this->getOption('right_field')] : null;

		// O valor será convertido para um inteiro representando o timestamp desde que a data passada
		// esteja em um formato aceito
		$leftValue_cmp = strtotime(is_numeric($leftValue)?'@'.$leftValue:str_replace("/","-",$leftValue));
		$rightValue_cmp = strtotime(is_numeric($rightValue)?'@'.$rightValue:str_replace("/","-",$rightValue));
		switch ($this->getOption('operator'))
		{
			case self::GREATER_THAN:
				$valid = $leftValue_cmp > $rightValue_cmp;
				break;
			case self::GREATER_THAN_EQUAL:
				$valid = $leftValue_cmp >= $rightValue_cmp;
				break;
			case self::LESS_THAN:
				$valid = $leftValue_cmp < $rightValue_cmp;
				break;
			case self::LESS_THAN_EQUAL:
				$valid = $leftValue_cmp <= $rightValue_cmp;
				break;
			case self::NOT_EQUAL:
				$valid = $leftValue_cmp != $rightValue_cmp;
				break;
			case self::EQUAL:
				$valid = $leftValue_cmp == $rightValue_cmp;
				break;
			default:
				throw new InvalidArgumentException(sprintf('O  operador "%s" não existe.', $this->getOption('operator')));
		}

		if (!$valid)
		{
			$error = new sfValidatorError($this, 'invalid', array(
        'left_field'  => $leftValue,
        'right_field' => $rightValue,
        'operator'    => $this->getOption('operator'),
			));
			if ($this->getOption('throw_global_error'))
			{
				throw $error;
			}

			throw new sfValidatorErrorSchema($this, array($this->getOption('left_field') => $error));
		}

		return $values;
	}

	/**
	 * @see sfValidatorBase
	 */
	public function asString($indent = 0)
	{
		$options = $this->getOptionsWithoutDefaults();
		$messages = $this->getMessagesWithoutDefaults();
		unset($options['left_field'], $options['operator'], $options['right_field']);

		$arguments = '';
		if ($options || $messages)
		{
			$arguments = sprintf('(%s%s)',
			$options ? sfYamlInline::dump($options) : ($messages ? '{}' : ''),
			$messages ? ', '.sfYamlInline::dump($messages) : ''
			);
		}

		return sprintf('%s%s %s%s %s',
		str_repeat(' ', $indent),
		$this->getOption('left_field'),
		$this->getOption('operator'),
		$arguments,
		$this->getOption('right_field')
		);
	}
}
