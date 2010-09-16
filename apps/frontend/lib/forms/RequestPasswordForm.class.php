<?php

/**
 * RequestPassword form.
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RequestPasswordForm extends BaseForm
{
 /**
   * @see sfForm
   */
  public function setup()
  {
    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(),
      'username' => new sfWidgetFormInputPassword(),
    ));

    $this->setValidators(array(
      'email' => new sfValidatorEmail(),
      'username' => new sfValidatorString(),      
    ));

    $this->validatorSchema->setPostValidator(new myValidatorRequestPassword());

    $this->widgetSchema->setNameFormat('request[%s]');
  }
}
