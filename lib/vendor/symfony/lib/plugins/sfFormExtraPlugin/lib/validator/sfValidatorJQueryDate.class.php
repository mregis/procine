<?php

/*
 * This file is part of the autorizacao package.
 * (c) Marcos Regis <marcos.regis@finnet.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorJQueryDate valida uma data passada como string. Também converte o valor da data para um valor válido.
 *
 * @package    autorizacao
 * @subpackage validator
 * @author     Marcos Regis <marcos.regis@finnet.com.br>

 * @version    1.0
 */
class sfValidatorJQueryDate extends sfValidatorBase
{
	/**
	 * Configures the current validator.
	 *
	 * Available options:
	 *
	 *  * date_format:             Uma expressão regular que a data deve validar
	 *  * with_time:               true se o validador deve retornar a hora, do contrário falso
	 *  * date_output:             O formato de retorno da data (default para d/m/Y)
	 *  * datetime_output:         O formato a ser usado quando retornando a data com o horário (default to d/m/Y H:i:s)
	 *  * date_format_error:       Formato da data a ser usado quando exibindo o erro para uma data que não esteja no formato adequado (usa date_format se não for ajustado)
	 *  * max:                     A data máxima permitida (formato timestamp)
	 *  * min:                     A data mínima permitida (formato timestamp)
	 *  * date_format_range_error: Formato da data a ser usado quando exibindo um erro de min/max (default para d/m/Y H:i:s)
	 *
	 * Códigos de erro disponíveis:
	 *
	 *  * bad_format
	 *  * min
	 *  * max
	 *
	 * @param array $options    Vetor de opções
	 * @param array $messages   Vetor de mensagens
	 *
	 * @see sfValidatorDate
	 */
	protected function configure($options = array(), $messages = array())
	{
		
		$this->addMessage('bad_format', '"%value%" não atende ao formato (%date_format%).');
		$this->addMessage('max', 'A data deve ser inferior a %max%.');
		$this->addMessage('min', 'A data deve ser posterior a %min%.');
		$this->addMessage('invalid', '%value% não é uma data válida.');
		
		$this->addOption('date_format', '#\d{1,2}\D\d{1,2}\D\d{2,4}#');
		$this->addOption('with_time', false);
		$this->addOption('date_output', 'd/m/Y');
		$this->addOption('datetime_output', 'd/m/Y H:i:s');
		$this->addOption('date_format_error','d-m-Y H:i:s' );
		$this->addOption('min', null);
		$this->addOption('max', null);
		$this->addOption('date_format_range_error', 'd-m-Y H:i:s');		
	}

	
	
	/**
	 * Valida o valor do campo.
	 *
	 * Este método é também responsável por "trimar" o valor do campo
	 * e checar as opções requeridas.
	 *
	 * @param  mixed $value  O valor do campo
	 * @return mixed O valor validado
	 * @throws sfValidatorError
	 */
	protected function doClean($value)
	{
		
		// Validando o formato
		if (!preg_match($this->getOption('date_format'), $value))
		{
			throw new sfValidatorError($this, 'bad_format', array('value' => $value, 'date_format' => $this->getOption('date_format_error') ? $this->getOption('date_format_error') : $this->getOption('date_format')));
		}

		// Removendo os separadores
		$v = str_replace("/","-",$value);
		
		// Convertendo para timestamp
		$clean = strtotime($v);
		
		// Validando a data
		if(false === $clean  || !(date('d-m-Y',$clean)==$v || date('Y-m-d',$clean)==$v || date('m-d-Y',$clean)==$v) ){
			throw new sfValidatorError($this, 'invalid', array('value' => $value));
		}
		

		else
		{
			$clean = (integer) $clean;
		}

		if ($this->hasOption('max') && $clean > $this->getOption('max'))
		{
			throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => date($this->getOption('date_format_range_error'), $this->getOption('max'))));
		}

		if ($this->hasOption('min') && $clean < $this->getOption('min'))
		{
			throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => date($this->getOption('date_format_range_error'), $this->getOption('min'))));
		}
		return $clean === $this->getEmptyValue() ? $clean : date($this->getOption('with_time') ? $this->getOption('datetime_output') : $this->getOption('date_output'), $clean);	
		
	}

}
