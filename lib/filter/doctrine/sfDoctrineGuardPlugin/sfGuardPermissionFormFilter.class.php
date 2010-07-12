<?php

/**
 * sfGuardPermission filter form.
 *
 * @package    Procine
 * @subpackage filter
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardPermissionFormFilter extends PluginsfGuardPermissionFormFilter
{
	public function configure()
	{
	}
	
  public function setup()
  {
  	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('empty_label'=>__('is empty',array(),'sf_admin'))),
      'description' => new sfWidgetFormFilterInput(array('empty_label'=>__('is empty',array(),'sf_admin'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false,
    												'template'=>__('from %from_date%<br />to %to_date%',array(),'sf_admin'),
    												'empty_label'=>__('is empty',array(),'sf_admin')    
    												)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false,
    												'template'=>__('from %from_date%<br />to %to_date%',array(),'sf_admin'),
    												'empty_label'=>__('is empty',array(),'sf_admin')    												
    												)),
      'groups_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'users_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'groups_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'users_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_permission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

  }	
}
