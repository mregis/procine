<?php

/**
 * UsuarioEmpresa form base class.
 *
 * @method UsuarioEmpresa getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUsuarioEmpresaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usuario_id' => new sfWidgetFormInputHidden(),
      'empresa_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'usuario_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'usuario_id', 'required' => false)),
      'empresa_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'empresa_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario_empresa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsuarioEmpresa';
  }

}
