<?php

/**
 * Usuario form base class.
 *
 * @method Usuario getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'login'           => new sfWidgetFormInputText(),
      'nome'            => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'cpf'             => new sfWidgetFormInputText(),
      'data_nascimento' => new sfWidgetFormDate(),
      'algoritmo'       => new sfWidgetFormInputText(),
      'salt'            => new sfWidgetFormInputText(),
      'senha'           => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'ultimo_acesso'   => new sfWidgetFormDateTime(),
      'empresa_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Empresa')),
      'perfis_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Perfil')),
      'processos_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Processo')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'login'           => new sfValidatorString(array('max_length' => 128)),
      'nome'            => new sfValidatorString(array('max_length' => 255)),
      'email'           => new sfValidatorEmail(array('max_length' => 255)),
      'cpf'             => new sfValidatorString(array('max_length' => 11, 'required' => false)),
      'data_nascimento' => new sfValidatorDate(array('required' => false)),
      'algoritmo'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'salt'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'senha'           => new sfValidatorString(array('max_length' => 128)),
      'status'          => new sfValidatorInteger(array('required' => false)),
      'ultimo_acesso'   => new sfValidatorDateTime(array('required' => false)),
      'empresa_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Empresa', 'required' => false)),
      'perfis_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Perfil', 'required' => false)),
      'processos_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Processo', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['empresa_list']))
    {
      $this->setDefault('empresa_list', $this->object->Empresa->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['perfis_list']))
    {
      $this->setDefault('perfis_list', $this->object->Perfis->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['processos_list']))
    {
      $this->setDefault('processos_list', $this->object->Processos->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveEmpresaList($con);
    $this->savePerfisList($con);
    $this->saveProcessosList($con);

    parent::doSave($con);
  }

  public function saveEmpresaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['empresa_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Empresa->getPrimaryKeys();
    $values = $this->getValue('empresa_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Empresa', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Empresa', array_values($link));
    }
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
