<?php

class myUser extends sfBasicSecurityUser

{
	const ERROR='erro',
	SUCCESS='sucesso',
	WARNING='aviso';

	public function myUser(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
	{
		parent::__construct($dispatcher,$storage,$options);
	}
	
	/**
	 * Retorna se o usu�rio est� em simulacao
	 * @return bool simulacao
	 */
	public function isSimulacao()
	{
		return $this->getAttribute('simulacao');
	}

	/**
	 * Set value for property simulacao
	 * @param bool {simulacao}
	 * @access public
	 */
	public function setSimulacao($simulacao)
	{
		$this->setAttribute('simulacao',(bool)$simulacao);
	}

	/**
	 * Retorna o valor do atributo simulacao armazenado no objeto.
	 * @return bool
	 */
	public function getSimulacao()
	{
		return $this->getAttribute('simulacao');
	}

	/**
	 * Termina a simula��o retornando o usu�rio logado como usu�rio ativo
	 */
	public function endSimulacao()
	{
		if($this->getSimulacao()==true){
			$this->setAttribute('usuario',$this->getAttribute('usuario_logado'));
			$this->setAttribute('perfil',$this->getAttribute('perfil_logado'));
			$this->setSimulacao(false);
			$this->populateCredentials();
		}
	}

	/**
	 * A simula��o consiste em alterar o Objeto Usu�rio (usu�rio ativo),
	 * seu Perfil (perfil ativo) e suas credenciais de acesso ao sistema
	 * para o usu�rio que ser� simulado.
	 *
	 * @param Usuario $usuario
	 */
	public function startSimulacao(Usuario $usuario)
	{
		// Recuperamos o perfil do usu�rio a ser simulado
		if($perfil = $usuario->getSinglePerfilForAplicativo()){
			$usuario->setUltimoAcesso(time()); // para garantir unicidade para o menu
				
			// Tudo certo, possui perfil, podemos iniciar a simulacao
			$this->setAttribute('perfil',$perfil);
			$this->setAttribute('usuario',$usuario);
			$this->setSimulacao(true);
				
			$this->populateCredentials();
		}
		else
		{
			throw new Exception("Usu�rio sem Perfil");
		}
		return $this;
	}

	/**
	 * Adiciona uma mensagem a fila de mensagens
	 * @param string $message Texto da mensagem
	 * @param [int $type=SUCESS] Tipo da mensagem
	 * @return myUser
	 */
	public function addMessage($message, $type=myUser::SUCCESS)
	{
		$messages = $this->getAttribute('messages');
		$messages[$type][]=$message;
		$this->setAttribute('messages',$messages);
		return $this;
	}		

	/**
	 * Retorna as mensagens enfileiradas
	 * @param [int $type=0] O Tipo da mensagem a ser retornada [Default 0 - Retorna todas as mensagens]
	 * @param [bool $keep=false] Indica se a mensagem ser� mantida na fila ap�s ser recuperada [Default false - remove a mensagem da fila] 
	 * @return array
	 */
	public function getMessages($type=0,$keep=false)
	{
		$messages = $this->getAttribute('messages');
		
		$return = ($type>0?(isset($messages[$type])?$messages[$type]:array()):$messages);
		if($keep==false)
		{
			if($type>0) unset($messages[$type]);
			else $messages=array();
		}						
		$this->setAttribute('messages',$messages);
		return $return;
		
	}

	/**
	 * Limpa todas as mensagens enfileiradas
	 * @return myUser
	 */
	public function clearMessages()
	{
		$this->setAttribute('messages',array());
		return $this;
	} 
	
	/**
	 * Verifica se h� mensagens na fila
	 * 
	 * @return bool 
	 */
	public function hasMessage()
	{
		return (count($this->getAttribute('messages'))>0);		
	}
	
	public function setReferer($referer)
	{
		$this->referer=$referer;
		return $this;
	}
}
