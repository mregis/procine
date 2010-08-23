<?php

/**
 * Menu form base class.
 *
 * @method Menu getObject() Returns the current form's model object
 *
 * @package    Procine
 * @subpackage form
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'processo_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Processo'), 'add_empty' => true)),
      'descricao'   => new sfWidgetFormInputText(),
      'ordem'       => new sfWidgetFormInputText(),
      'menu_pai'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Menu'), 'add_empty' => true)),
      'status'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'processo_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Processo'), 'required' => false)),
      'descricao'   => new sfValidatorString(array('max_length' => 20)),
      'ordem'       => new sfValidatorInteger(array('required' => false)),
      'menu_pai'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Menu'), 'required' => false)),
      'status'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Menu';
  }

}
