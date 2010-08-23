<?php

/**
 * PerfilProcesso form base class.
 *
 * @method PerfilProcesso getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePerfilProcessoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'processo_id' => new sfWidgetFormInputHidden(),
      'perfil_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'processo_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'processo_id', 'required' => false)),
      'perfil_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'perfil_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perfil_processo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PerfilProcesso';
  }

}
