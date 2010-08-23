<?php

/**
 * Perfil form base class.
 *
 * @method Perfil getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePerfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'descricao'      => new sfWidgetFormInputText(),
      'nivel'          => new sfWidgetFormInputText(),
      'status'         => new sfWidgetFormInputText(),
      'usuarios_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Usuario')),
      'processos_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Processo')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'descricao'      => new sfValidatorString(array('max_length' => 50)),
      'nivel'          => new sfValidatorInteger(),
      'status'         => new sfValidatorInteger(array('required' => false)),
      'usuarios_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Usuario', 'required' => false)),
      'processos_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Processo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('perfil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Perfil';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usuarios_list']))
    {
      $this->setDefault('usuarios_list', $this->object->Usuarios->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['processos_list']))
    {
      $this->setDefault('processos_list', $this->object->Processos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUsuariosList($con);
    $this->saveProcessosList($con);

    parent::doSave($con);
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

  public function saveProcessosList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['processos_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Processos->getPrimaryKeys();
    $values = $this->getValue('processos_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Processos', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Processos', array_values($link));
    }
  }

}
