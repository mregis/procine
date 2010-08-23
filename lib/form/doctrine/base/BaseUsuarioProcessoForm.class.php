<?php

/**
 * UsuarioProcesso form base class.
 *
 * @method UsuarioProcesso getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUsuarioProcessoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id'  => new sfWidgetFormInputHidden(),
      'processo_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'usuario_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'usuario_id', 'required' => false)),
      'processo_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'processo_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_processo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioProcesso';
  }

}
