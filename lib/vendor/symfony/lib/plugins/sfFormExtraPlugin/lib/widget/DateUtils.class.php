<?php

class DateUtils {


	/**
	 * Adiciona a quantidade de dias/horas/minutos/segundos a data passada
	 * retornando um timestamp que pode ser utilizado para comparações de datas
	 * e usada com funções que utilizem timestamp (como date e strftime)
	 * Os valores válidos para o parâmetro <var>$data</var> são datas válidas
	 * de acordo com a sintaxe de data GNU (http://www.gnu.org/software/tar/manual/html_node/tar_109.html) ou
	 * um timestamp (número de segundos desde a era UNIX)
	 * Os valores para dias/horas/minutos/segundos podem ser negativos para pegar datas no passado da data passada
	 *
	 * @param $data mixed Uma data passada em formato suportado por strtotime
	 * @param $dias int quantidade de dias para ser adicionado a data passada
	 * @param $horas int quantidade de horas a ser adicionada
	 * @param $minutos int quantidade de minutos a ser adicionado
	 * @param $segundos int quantidade de segundos a ser adicionado
	 * @return int Timestamp da data gerada
	 */
	static public function addToDate($data,$dias,$horas=0,$minutos=0,$segundos=0){
		try{
			if(is_numeric($data)){
				$data='@'.$data;
			}
			$timestamp = strtotime($data,time());
			$toAdd = intval($dias)*24*3600;
			if( ($horas = intval($horas))>0){
				$toAdd += $horas*3600;
			}
			if( ($minutos = intval($minutos))>0){
				$toAdd += $minutos*60;
			}
			if( ($segundos = intval($segundos))>0){
				$toAdd += $segundos;
			}
			return $timestamp+$toAdd;
		}catch(Exception $e){
			return -1;
		}
	}

	/**
	 * Retorna o valor dos milisengundos atual
	 * @return int milisegundos
	 */
	static public function milisegundos(){
		return preg_replace("#^(?:[0\.]+)?(\d{3}).+$#","$1",microtime());
	}

	/**
	 * Converte uma data passada em qualquer formato para um formato de saída
	 * Obs.: Datas passadas com separadores (Qualquer Caracter não numérico)
	 * Têm mais chances de ser convertida corretamente
	 * Datas sem separadores serão tratados como DiaMesAno caso
	 * não seja passado o formato da data passada
	 * Exemplos.:
	 * DateUtils::converterData('2008/03/16') retorna 16/03/2008
	 * DateUtils::converterData('2008-3-16') retorna 16/03/2008
	 * DateUtils::converterData('2008-3-16',dmY) retorna 16032008
	 * DateUtils::converterData('20080316') retorna 16/03/2008
	 * DateUtils::converterData('16032008') retorna 31/12/1969 (falha porque tenta usar a data como 1603/20/08)
	 * DateUtils::converterData('16032008','Ymd','dmY') retorna 16032008
	 * DateUtils::converterData('16032008','r','dmY')
	 * DateUtils::converterData('16032008','r','dmY')
	 * Sun, 16 Mar 2008 00:00:00 -0300
	 * @param string {data} A data a ser convertida
	 * @param string {mascara} A máscara de saída da função (Utiliza a sintaxe de date())
	 * @param string {formato} Define como a data passada deve ser tratada caso a
	 * data seja passada sem separadores (Utilizar o formato de datas GNU)
	 */
	static public function converterData($data,$mascara='d/m/Y',$formato='Ymd'){
		if(!preg_match("#^\d(1,2)\D\d{1,2}\D\d{1,2}$#",$data) && preg_match("#\D#",$data)){
			$stamp =  self::_strtotime($data,time());
		}else{
			$trans = array('d'=>'(\d{2})',
							'm'=>'(\d{2})',
							'y'=>'(\d{1,2})',
							'Y'=>'(\d{2,4})');
			$replace = str_replace('d','$3',$formato);
			$replace =str_replace('m','$2',$replace);
			$replace =str_replace('Y','$1',$replace);
			$replace =str_replace('y','$1',$replace);
			$regex = strtr($formato,$trans);
			$dt = preg_replace("#$regex#","$replace",$data);
			$stamp = strtotime($dt,time());
		}
		return date($mascara,$stamp);
	}

	/**
	 * Função para sobrescrever a função date nativa devido a um comportamento
	 * específico do MySQL e de campos em EDI que utilizam a data com valor 0 quando esta é nula
	 * ou vazia
	 * A função utiliza o mesmo comportamento que a função date nativa, com exceção de quando ela
	 * possui o valor 0
	 * @param $mascara O Formato de saída
	 * @param $data
	 * @return string A Data no formato requisitado
	 */
	static public function date($mascara='Ymd',$timestamp=NULL){
		if($timestamp===NULL){
			$return = date($mascara);
		}else{
			$return = date($mascara,(int)$timestamp);
		}
		if($timestamp===0){
			$return = preg_replace("#\d#","0",$return);
		}elseif($timestamp===''){
			$return = preg_replace("#\d#"," ",$return);
		}
		return $return;
	}

	/**
	 * Função strtotime melhorada
	 * @tutorial A função strtotime nativa do PHP tem um funcionamento diferente para quando o separador é a barra
	 * ao invés do hífen e o ano é o último parâmetro.
	 * @example date('d/m/Y',strtotime('01/03/2009')) retornará 03/01/2009
	 * 			date('d/m/Y',strtotime('05/01/2009')) retornará 01/05/2009
	 * porém, quando o separador é o hífen a data é retornada é a que segue
	 * 			date('d/m/Y',strtotime('01-03-2009')) retornará 01/03/2009
	 * 			date('d/m/Y',strtotime('05-01-2009')) retornará 05/01/2009
	 * Como em todos os projetos usamos datas no padrão brasileiro esta função
	 * substitui e facilita a conversão das datas
	 * @param string $data
	 * @return int
	 */
	static public function _strtotime($data=NULL){
		if ($data===NULL) return NULL;
		if (trim($data)==='') return '';
		if(preg_replace("#[0\D]+#","",$data)==""){
			return 0;
		}
		$data = preg_replace("#[^\d@]#","-",$data);
		if(strlen($data)<8){
			$data = preg_replace("#^(\d+)\D(\d+)\D(\d+)$#","$3-$2-$1",$data);
		}
		return strtotime($data,time());
	}


	/**
	 * Compara duas datas dizendo quem é a maior
	 * @param string {data1} Data a ser verificada se é maior ou menor
	 * @param string {data2} Data a ser usada como base na comparação
	 * @return int (-1 quando a data1 for maior que data2,
	 * 				0 quando forem iguais,
	 * 				1 quando a data1 for menor que a data 2)
	 */
	static public function comparaDatas($data1, $data2){
		$data1 = self::converterData($data1,'YmdHms');
		$data2 = self::converterData($data2,'YmdHms');
		if($data1>$data2){
			return 1;
		}elseif($data1==$data2){
			return 0;
		}else return -1;
	}

}
