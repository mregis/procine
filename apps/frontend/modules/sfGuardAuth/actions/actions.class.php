<?php

require_once(sfConfig::get('sf_symfony_lib_dir').'/plugins/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class sfGuardAuthActions extends BasesfGuardAuthActions
{
	public function executePassword($request)
	{

	}
	
	/**
	 * Eefetua o login
	 * @param sfWebRequest $request
	 */
	public function executeSignin($request)
	{
		$this->setLayout('base');
		return parent::executeSignin($request);
		
	}
}
