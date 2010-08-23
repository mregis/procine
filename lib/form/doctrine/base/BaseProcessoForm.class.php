<?php

/**
 * Processo form base class.
 *
 * @method Processo getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseProcessoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'descricao'     => new sfWidgetFormInputText(),
      'rota'          => new sfWidgetFormInputText(),
      'status'        => new sfWidgetFormInputText(),
      'perfis_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Perfil')),
      'usuarios_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Usuario')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'descricao'     => new sfValidatorString(array('max_length' => 60)),
      'rota'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'status'        => new sfValidatorInteger(array('required' => false)),
      'perfis_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Perfil', 'required' => false)),
      'usuarios_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Usuario', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('processo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Processo';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['perfis_list']))
    {
      $this->setDefault('perfis_list', $this->object->Perfis->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['usuarios_list']))
    {
      $this->setDefault('usuarios_list', $this->object->Usuarios->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePerfisList($con);
    $this->saveUsuariosList($con);

    parent::doSave($con);
  }

  public function savePerfisList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['perfis_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Perfis->getPrimaryKeys();
    $values = $this->getValue('perfis_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Perfis', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Perfis', array_values($link));
    }
  }

  public function saveUsuariosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usuarios_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Usuarios->getPrimaryKeys();
    $values = $this->getValue('usuarios_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Usuarios', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Usuarios', array_values($link));
    }
  }

}
