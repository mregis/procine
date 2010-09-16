<?php
/**
 *
 * @package    procine
 * @subpackage validator
 * @author     Marcos Regis <marcos@marcosregis.com>
 */
class myValidatorRequestPassword extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('email_field', 'email');
    $this->addOption('username_field', 'username');
    $this->setMessage('invalid', 'The username is invalid.');
  }

  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    $email = isset($values[$this->getOption('email_field')]) ? $values[$this->getOption('email_field')] : '';

    // user exists?
    if ($username && $email = $this->getTable()->findOneByLogin($username))
    {
      // email is ok?
      if ($user->getStatus()==1 && $user->getEmail()==$email)
      {
        return array_merge($values, array('user' => $user));
      }
    }

    if ($this->getOption('throw_global_error'))
    {
      throw new sfValidatorError($this, 'invalid');
    }

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
  }

  protected function getTable()
  {
    return Doctrine::getTable('Usuario');
  }
}
