<?php

/**
 * UsuarioPerfil form base class.
 *
 * @method UsuarioPerfil getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUsuarioPerfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'perfil_id'  => new sfWidgetFormInputHidden(),
      'usuario_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'perfil_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'perfil_id', 'required' => false)),
      'usuario_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'usuario_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_perfil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioPerfil';
  }

}
