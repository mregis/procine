<?php
class Mascaras {

	// Constantes definidas para uso interno
	const CPF=1;
	const CNPJ=2;
	const INSC_ESTADUAL=3;
	const RG=4;

	/**
	 * Retorna um CNPJ passado utilizando a m�scara padr�o
	 * ##.###.###/####-##
	 * @param string $cnpj O CNPJ a ser mascarado
	 * @return string CNPJ mascarado
	 */
	static public function formataCNPJ($cnpj) {
		if($cnpj=="") return $cnpj;
		// deixando apenas n�meros
		$cnpj =preg_replace("#\D#","",$cnpj);
		$cnpj = str_pad($cnpj,14,'0',STR_PAD_LEFT);
		return preg_replace("#\d*(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$#","$1.$2.$3/$4-$5",$cnpj);

	}

	/**
	 * Retorna um CPF passado utilizando a m�scara padr�o
	 * ###.###.###-##
	 * @param string $cpf O CPF a ser mascarado
	 * @return string CPF mascarado
	 */
	static public function formataCPF($cpf){
		// deixando apenas n�meros
		$cpf = preg_replace("#\D#","",$cpf);
		return preg_replace("#(\d{3})(\d{3})(\d{3})(\d{2})#","$1.$2.$3-$4",$cpf);
	}

	/**
	 * Mascara um n�mero de telefone passado no formato (##) ####-####
	 *
	 * @param string tel O n�mero de telefone a ser mascarado
	 * @return string N�mero de telefone mascarado
	 */
	static public function formataTelefone($tel){
		$tel = preg_replace("#\D#","",$tel);
		if(strlen($tel)<4)
		{
			return $tel;
		}
		else
		{
			$tel = str_pad($tel,10,' ',STR_PAD_LEFT);
			return preg_replace( "#[\d\s]*([\d\s]{2})([\s\d]{4})([\d\s]{4})$#","($1) $2-$3",$tel);
		}
	}

	/**
		* Valida um valor como um CEP
		* @param string $cep O CEP a ser validado (formato NNNNN-NNN ou NNNNNNNN)
		* @return string
		*/
	static public function formataCEP($cep) {
			
		$cep = str_pad(preg_replace("#\D#","",$cep),8,'0',STR_PAD_LEFT);
		if(intval($cep)==0) return "";
		$cep = preg_replace("#^(\d{5})(\d{3})$#","$1-$2", $cep);
		return $cep;
	}

	/**
		* Valida um valor como uma raz�o
		* @param string $cep A raz�o a ser formatada (formato ##-## ####)
		* @return string Razao formatada em ##-##
		*/
	static public function formataRazao($razao,$mask="##-##") {
		$razao = str_pad($razao,4,'0',STR_PAD_LEFT);
		return preg_replace("#^.*?(.{2})(.{2})$#","$1-$2", $razao);
	}

	/**
	 * Retorna um n�mero passado formatado para ser exibido como
	 * moeda de uma determinada localidade (Default � Brasil)
	 *
	 * @param float $numero
	 * @param mixed $localidade A localidade desejada (pode ser uma string ou um vetor com as localidades desejadas)
	 * @return string (Valor formatado como moeda)
	 * @version 2.1
	 */
	static public function _money_format($numero,$localidade='ptb,pt_BR',$use_simbol=FALSE){
		try{
			if($numero=='') return '';
			if(!is_array($localidade)){
				$localidade = explode(',',$localidade);
			}
			//				$numero_base = 5/2;
			$locale = setlocale(LC_ALL,0);
			setlocale(LC_ALL,$localidade);

			$locale_info = localeconv();
			$separador_decimal= $locale_info["mon_decimal_point"];

			$separador_milhar = $locale_info["mon_thousands_sep"];
			setlocale(LC_ALL,$locale);
			return (number_format($numero,2,$separador_decimal,$separador_milhar));
		}catch(Exception $e){
			trigger_error($e->getMessage());
			return null;
		}
	}

	/**
		* Formata um valor passado em ####n-#
		* @param string $num O valor a ser formatado (formato ######)
		* @return string Valor formatada em #####-#
		*/
	static public function formataNum($valor) {
		return preg_replace("#(.)$#","-$1", trim($valor));
	}


	/**
	 * Formata uma sequencia num�rica incluindo os separadores de
	 * decimais e de milhares
	 * Funciona de forma an�loga a number_format, com exce��o de que recebe
	 * uma string ao inv�s de um float e os valores default para separadores de
	 * decimais e milhares est�o no formato brasileiro
	 *
	 * @param mixed $number  O valor a ser formatado
	 * @param int $decimais A quantidade de casas decimais (default 2)
	 * @param [string $separador_decimal=','] O separador de decimais
	 * @param [string $separador_milhar='.'] O separador de milhares
	 * @return string
	 */
	static public function _number_format($number,$decimais=2,$separador_decimal=",",$separador_milhar="."){		
		// N�mero vazio?		
		if(trim($number)=="") return $number;
		// se for um double precisamos garantir que n�o ser� covertido em
		// nota��o cient�fica e que valores terminados em .90 tenha o zero removido
		if(is_float($number) || is_double($number)){
			$number = sprintf("%.{$decimais}f",$number);
		}
		// Convertendo para uma string num�rica
		$number = preg_replace('#\D#','',$number);
				
		// separando a parte decimal
		$decimal='';
		if($decimais>0){
			$number = sprintf("%.{$decimais}f",($number / pow(10,$decimais)));			
			if(preg_match("#^(\d+)\D(\d{{$decimais}})$#",$number,$matches)){
				$decimal=$separador_decimal . $matches[2];
				$number=$matches[1];
			}
		}
		// formatando a parte inteira
		if($separador_milhar!=''){
			$number = implode($separador_milhar,array_reverse(array_map('strrev',str_split(strrev($number),3))));
		}
		return $number . $decimal;
	}

	/**
	 * Mascara os dados quando o usu�rio passado estiver sendo simulado $_SESSION['simulacao'] existir
	 * @param string dados Os dados a serem obfuscados
	 * @return string
	 * @deprecated
	 */
	static public function obfuscate($dados, myUser $user){
		if(!$usuario = $user->getAttribute('usuario_logado')){
			throw new sfActionException("N�o foi poss�vel definir a identidade do usu�rio logado!",515);
		}else{
			$nivel = $usuario->getSinglePerfilForAplicativo()->getNivel();
			if($user->isSimulacao() && $nivel > MASTER_BANCO ){
				$dados = preg_replace("#[^\d\W]#","X",$dados);
				$dados = preg_replace("#\d#","9",$dados);
			}
		}
		return $dados;
	}

	/**
	 * Formata uma inscri��o passada de acordo com o estado
	 *
	 * @param string $inscricao A inscri��o a ser formatada
	 * @param string $estado A Sigla do Estado para qual a inscri��o ser� formatada (defalut = S�o Paulo)
	 */
	static public function formataInscricaoEstadual($inscricao,$estado='SP'){
		// Caso for a string ISENTO
		if(strtolower($inscricao)=='isento' || strtolower($inscricao)=='isenta'){
			return str_pad('ISENTO',14,' ',STR_PAD_RIGHT);
		}

		// Para cada estado existe uma m�scara e uma regra espec�fica
		switch(strtolower($estado)){

			case 'SP': // S�o Paulo
				if(substr($inscricao,0,1)=='P'){
					// removendo caracteres n�o num�ricos
					$inscricao = preg_replace("#\D#","",$inscricao);
					// efetuando padding para que fique do tamanho correto
					$inscricao = str_pad($inscricao,13,'0',STR_PAD_LEFT);
					$inscricao = preg_replace('#(\d{8})(\d)(\d{3})$#',"P-$1.$2/$3",$inscricao);
				}else{
					// removendo caracteres n�o num�ricos
					$inscricao = preg_replace("#\D#","",$inscricao);
					// efetuando padding para que fique do tamanho correto
					$inscricao = str_pad($inscricao,12,'0',STR_PAD_LEFT);
					$inscricao = preg_replace('#(\d{3})(\d{3})(\d{3})(\d{3})$#',"$1.$2.$3.$4",$inscricao);
				}
				break;
					
			case 'AC':	// Acre
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,14,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d{2})(\d{4})(\d)$#',"$1.$2.$3-$4",$inscricao);
				break;

			case 'BA':	// Bahia
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,8,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{6})(\d{2})$#',"$1-$2",$inscricao);
				break;

			case 'CE': case 'RR': case 'SE':	// Cear�, Roraima, Sergipe
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,9,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{8})(\d)$#',"$1-$2",$inscricao);
				break;

			case 'DF':	// Distrito Federal
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,13,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{3})(\d{5})(\d{3})(\d{2})$#',"$1.$2.$3-$4",$inscricao);
				break;

			case 'AL': case 'AP': case 'ES': // Alagoas, Amap�, Esp�rito Santo
			case 'MA': case 'MS': case 'PI':// Maranh�o, Mato Grosso do Sul, Piau�
			case 'RO': // Rond�nia
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,9,'0',STR_PAD_LEFT);
				return substr($inscricao,0,9);
				break;

			case 'AM' : case 'GO': case 'PB': // Amazonas, Goi�s, Para�ba
			case 'RN': // Rio Grande do Norte
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,9,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d{3})(\d{3})(\d)$#',"$1.$2.$3-$4",$inscricao);
				break;
					
			case 'MT': // Mato Grosso
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,11,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{10})(\d)$#',"$1-$2",$inscricao);
				break;

			case 'MG': // Minas Gerais
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,13,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{3})(\d{3})(\d{3})(\d{4})$#',"$1.$2.$3/$4",$inscricao);
				break;

			case 'PA': // Par�
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,9,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d{6})(\d)$#',"$1-$2-$3",$inscricao);
				break;

			case 'PE': // Pernambuco
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,14,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d)(\d{3})(\d{7})(\d)$#',"$1.$2.$3.$4-$5",$inscricao);
				break;

			case 'PR': // Paran�
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,10,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{3})(\d{5})(\d{2})$#',"$1.$2-$3",$inscricao);
				break;

			case 'RJ': // Rio de Janeiro
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,8,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d{3})(\d{2})(\d)$#',"$1.$2.$3-$4",$inscricao);
				break;

			case 'RS': // Rio Grande do Sul
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,10,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{3})(\d{6})(\d)$#',"$1/$2-$3",$inscricao);
				break;

			case 'SC': // Santa Catarina
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,9,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{3})(\d{3})(\d{3})$#',"$1.$2.$3",$inscricao);
				break;


			case 'TO': // Tocantins
				// removendo caracteres n�o num�ricos
				$inscricao = preg_replace("#\D#","",$inscricao);
				// efetuando padding para que fique do tamanho correto
				$inscricao = str_pad($inscricao,11,'0',STR_PAD_LEFT);
				$inscricao = preg_replace('#(\d{2})(\d{2})(\d{6})(\d)$#',"$1.$2.$3-$4",$inscricao);
				break;
		}
		return $inscricao;

	}

	/**
	 * Formata uma Inscri��o baseado no tipo. 
	 * Definidos em constantes da classe (default null [Auto])
	 *
	 * @param string $inscricao A inscri��o a ser mascarada
	 * @param [mixed $tipo=NULL] O Tipo da inscri��o. Os tipos poss�veis s�o 1=CPF, 2=CNPJ, 3=Inscri��o Estadual, 4=Registro Geral
	 */
	static public function formataInscricao($inscricao,$tipo=NULL){
		switch($tipo){
			case self::CNPJ: case 'cnpj':
				return self::formataCNPJ($inscricao);
				break;

			case self::CPF: case 'cpf':
				return self::formataCPF($inscricao);
				break;
					
			case NULL:
				if(strlen(preg_replace("#\D#","",$inscricao))>11){
					return self::formataCNPJ($inscricao);
				}else{
					return self::formataCPF($inscricao);
				}
			break;
			default:
				return $inscricao;
		}
	}

	/**
	 * Converte caracteres especiais de uma string passada ou remove-os caso n�o tenha um equivalente
	 *
	 * @param string $texto O texto a ter os caracaters convertidos/removidos
	 * @param [bool $removeNonConverted=true] Indica se um caracter n�o convertido deva ser mantido na string  
	 * @return string O texto convertido
	 */
	static public function removeSpecialChars($texto,$removeNonConverted=true){
		if(function_exists('mb_convert_encoding')){
			$texto = mb_convert_encoding($texto,"ISO-8859-1","UTF-8,ISO-8859-1,ASCII");
		}
		$trans = array(
	             '#[�����]#'=>'A',
	             '#[�����]#'=>'a',
	             '#[����]#'=>'E',
	             '#[����]#'=>'e',
	             '#[����]#'=>'I',
	             '#[����]#'=>'i',
	             '#[�����]#'=>'O',
	             '#[�����]#'=>'o',
	             '#[����]#'=>'U',
	             '#[����]#'=>'u',
	             '#�#'=>'c',
	             '#�#'=>'C');
		// Tira o acento pela chave do array
		$texto = preg_replace(array_keys($trans), array_values($trans), $texto);
		if($removeNonConverted===TRUE){
			$texto = preg_replace("#[^\w\d]#","", $texto);
		}
		return $texto;
	}
	
	static public function retornaInscricao($inscricao,$tipo=2){
		switch($tipo){
			case self::CNPJ: case 'cnpj':
				return self::retornaCNPJ($inscricao);
				break;

			case self::CPF: case 'cpf':
				return self::retornaCPF($inscricao);
				break;
					
			default:
				return $inscricao;
		}
	}

	static public function retornaCNPJ($cnpj) {
		if($cnpj=="") return $cnpj;
		// deixando apenas n�meros
		$cnpj =preg_replace("#\D#","",$cnpj);
		$cnpj = str_pad($cnpj,14,'0',STR_PAD_LEFT);
		return $cnpj;

	}

	/**
	 * Retorna um CPF passado utilizando a m�scara padr�o
	 * ###.###.###-##
	 * @param string $cpf O CPF a ser mascarado
	 * @return string CPF mascarado
	 */
	static public function retornaCPF($cpf){
		// deixando apenas n�meros
		$cpf = preg_replace("#\D#","",$cpf);
		return $cpf;
	}

}
