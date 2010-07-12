<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorInscricao valida inscrições.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorEmail.class.php 8835 2008-05-07 16:50:28Z nicolas $
 */
class sfValidatorInscricao extends sfValidatorBase
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
		$this->addMessage('inscricao_invalida', '"%value%" Não é uma inscrição válida.');
		$this->addOption('tipo', null);
	}

	/**
	 * @see sfValidatorBase
	 */
	protected function doClean($value)
	{

		$tipo = strtoupper($this->getOption('tipo'));
		if($tipo==NULL)
			$tipo = strlen(preg_replace("#\D#","",$value))>11?'CNPJ':'CPF';
		switch ($tipo) {
			// CPF
			case 1: case 'CPF':
				$clean = $this->CPF($value);
				$tipo="CPF";
				break;
				
			// CNPJ
			case 2: case 'CNPJ': default:
				$clean = $this->CNPJ($value);
				$tipo="CNPJ";
				break;
			case NULL:
				$clean = ($this->CNPJ($value) || $this->CPF($value));
				$tipo= $clean===true?(strlen($value)>11?'CNPJ':'CPF'):'Número';
				
					
		}

		if (false === $clean)
		{
			throw new sfValidatorError($this, 'inscricao_invalida', array('value' => $value,'tipo'=>$tipo));
		}

		return $value;
	}

	/**
	 * Valida um CPF passado
	 * @param {string} CPF CPF a ser validado
	 * @return {bool}
	 */
	private function CPF($cpf) {
		if ($cpf=="") return false;
		$cpf = preg_replace('#\D#','',$cpf);

		if (preg_match("#^(\d)\\1+$#", $cpf) || strlen($cpf) != 11 || $cpf=='12345678909') {
			return false;
		}

		$c = substr($cpf,0,9);
		$dv = substr($cpf,-2);
		$d1 = 0;
		for ($i=0; $i<9; $i++) {
			$d1 += $c{$i} * (10-$i);
		}
		if ($d1 == 0) return false;
		$d1 = 11 - ($d1 % 11);
		if ($d1 > 9) $d1 = 0;
		if ($dv{0} != $d1){
			return false;
		}
		$d1 *= 2;
		for ($i = 0; $i < 9; $i++)    {
			$d1 += $c{$i}*(11-$i);
		}
		$d1 = 11 - ($d1 % 11);
		if ($d1 > 9) $d1 = 0;
		if ($dv{1} != $d1){
			return false;
		}
		return true;
	}

	/**
	 * Valida um CNPJ passado
	 * @param string CNPJ CNPJ a ser validado
	 * @return bool
	 */
	private function CNPJ($cnpj) {
		$cnpj = preg_replace("#\D#", "", $cnpj);
		if (preg_match("#^(\d)\\1+$#", $cnpj) || strlen($cnpj) != 14) {
			return false;
		}
		$a = array ();
		$b = 0;
		$c = array (6,5,4,3,2,9,8,7,6,5,4,3,2);
		for ($i = 0; $i < 12; $i++) {
			$a[$i] = $cnpj {
				$i };
				$b += $a[$i] * $c[$i +1];
		}
		if (($x = $b % 11) < 2) {
			$a[12] = 0;
		} else {
			$a[12] = 11 - $x;
		}
		$b = 0;
		for ($y = 0; $y < 13; $y++) {
			$b += ($a[$y] * $c[$y]);
		}
		if (($x = $b % 11) < 2) {
			$a[13] = 0;
		} else {
			$a[13] = 11 - $x;
		}
		if (($cnpj{12}!= $a[12]) || ($cnpj{13}!= $a[13])) {
			return false;
		}
		return true;
	}
}
