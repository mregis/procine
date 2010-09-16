<?php

/**
 * login actions.
 *
 * @package    Procine
 * @subpackage login
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class loginActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->forward('login', 'signin');
	}

	public function executeSignin(sfWebRequest $request)
	{
		$user = $this->getUser();
		if ($user->isAuthenticated())
		{
			return $this->redirect('@homepage');
		}

		$this->form = new LoginForm();
		if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter($this->form->getName()));
			if ($this->form->isValid())
			{
				$values = $this->form->getValues();
				$this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

				// always redirect to a URL set in app.yml
				// or to the referer
				// or to the homepage
				$signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
				return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
			}

		}
		else
		{
			if ($request->isXmlHttpRequest())
			{
				$this->getResponse()->setHeaderOnly(true);
				$this->getResponse()->setStatusCode(401);

				return sfView::NONE;
			}

			// if we have been forwarded, then the referer is the current URL
			// if not, this is the referer of the current request
			$user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

			$module = sfConfig::get('sf_login_module');
			if ($this->getModuleName() != $module)
			{
				return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
			}

			$this->getResponse()->setStatusCode(401);
		}
	}
	
	public function executeSignout($request)
	{
		$this->getUser()->signOut();
		$signoutUrl = sfConfig::get('app_success_signout_url', $request->getReferer());
		$this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
	}	
	
	public function executePassword(sfWebRequest $request)
	{
		$user = $this->getUser();
		if ($user->isAuthenticated())
		{
			return $this->redirect('@homepage');
		}

		$this->form = new RequestPasswordForm();
		if ($request->isMethod('post'))
		{
			$this->form->bind($request->getParameter($this->form->getUsername()));
			if ($this->form->isValid())
			{
				$values = $this->form->getValues();
									

				// always redirect to a URL set in app.yml
				// or to the referer
				// or to the homepage
				$signinUrl = sfConfig::get('app_sf_guard_plugin_success_signin_url', $user->getReferer($request->getReferer()));
				return $this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
			}

		}
		else
		{
			if ($request->isXmlHttpRequest())
			{
				$this->getResponse()->setHeaderOnly(true);
				$this->getResponse()->setStatusCode(401);

				return sfView::NONE;
			}

			// if we have been forwarded, then the referer is the current URL
			// if not, this is the referer of the current request
			$user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

			$module = sfConfig::get('sf_login_module');
			if ($this->getModuleName() != $module)
			{
				return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
			}

			$this->getResponse()->setStatusCode(401);
		}		
	}
}
