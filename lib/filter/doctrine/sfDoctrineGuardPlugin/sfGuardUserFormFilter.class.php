<?php

/**
 * sfGuardUser filter form.
 *
 * @package    Procine
 * @subpackage filter
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserFormFilter extends PluginsfGuardUserFormFilter
{
  public function configure()
  {
  }
  
  public function setup()
  {
  	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
  	
    $this->setWidgets(array(
      'username'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'algorithm'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'             => new sfWidgetFormFilterInput(array('empty_label'=>__('is empty',array(),'sf_admin'))),
      'password'         => new sfWidgetFormFilterInput(array('empty_label'=>__('is empty',array(),'sf_admin'))),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => __('yes or no',array(),'sf_admin'), 1 => __('yes',array(),'sf_admin'), 0 => __('no',array(),'sf_admin')))),
      'is_super_admin'   => new sfWidgetFormChoice(array('choices' => array('' => __('yes or no',array(),'sf_admin'), 1 => __('yes',array(),'sf_admin'), 0 => __('no',array(),'sf_admin')))),
      'last_login'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(),
    												'template'=>__('from %from_date%<br />to %to_date%',array(),'sf_admin'),
    												'empty_label'=>__('is empty',array(),'sf_admin')
    													)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false,
    												'template'=>__('from %from_date%<br />to %to_date%',array(),'sf_admin'),
    												'empty_label'=>__('is empty',array(),'sf_admin')
    													)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false,
    												'template'=>__('from %from_date%<br />to %to_date%',array(),'sf_admin'),
    												'empty_label'=>__('is empty',array(),'sf_admin')
    													)),    													
      'groups_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
    ));
    $this->setValidators(array(
      'username'         => new sfValidatorPass(array('required' => false)),
      'algorithm'        => new sfValidatorPass(array('required' => false)),
      'salt'             => new sfValidatorPass(array('required' => false)),
      'password'         => new sfValidatorPass(array('required' => false)),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_super_admin'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_login'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'groups_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance(); 	
  }
}
