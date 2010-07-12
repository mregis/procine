<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
  }
  
  public function setup()
  {  	
  	parent::setup();
  	$this->widgetSchema['cpf'] = new sfWidgetFormInputInscricao(array('tipo'=>Mascaras::CPF));
  	$this->widgetSchema['data_nascimento'] = new sfWidgetFormJQueryInputDate();
  }
}
