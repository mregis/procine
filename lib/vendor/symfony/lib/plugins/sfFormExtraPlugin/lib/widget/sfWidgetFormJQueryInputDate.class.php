<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormJQueryInputDate represents a date widget rendered by JQuery UI.
 *
 * This widget needs JQuery, JQuery-DatePick and JQuery UI to work.
 *
 * @package    sfFormExtraPlugin
 * @subpackage widget
 * @author     Marcos Regis <marcos@marcosregis.com>
 * @version    SVN: $Id: sfWidgetFormJQueryInputDate.class.php 16262 2009-03-12 14:02:33Z fabien $
 */
class sfWidgetFormJQueryInputDate extends sfWidgetFormInput
{
	/**
	 * Configures the current widget.
	 *
	 * Available options:
	 *
	 *  * image:   The image path to represent the widget (false by default)
	 *  * config:  A JavaScript array that configures the JQuery date widget
	 *  * culture: The user culture
	 *  * mascara: Mascara padrão de saída para uma data pré-existente
	 *  * img_attrs: An array of options for the image (Default = width="16" and height="16")
	 *  * img_position: The Captcha image position. [LEFT | RIGHT | TOP | BOTTOM, default=LEFT]
	 *
	 * @param array $options     An array of options
	 * @param array $attributes  An array of default HTML attributes
	 *
	 * @see sfWidgetFormInput
	 */
	protected function configure($options = array(), $attributes = array())
	{
		$this->addOption('img_attrs',array('width'=>16,'height'=>16));
		$this->addOption('img_position','RIGHT');
		$this->addOption('image', '/sf/sf_default/images/calendar.png');
		$this->addOption('config', '{}');
		$this->addOption('culture', 'pt_BR');
		$this->addOption('mascara', 'd/m/Y');

		$this->setOption('is_hidden', false);
		$this->setAttribute('width', 11);
		$this->setAttribute('maxlength', 10);

		parent::configure($options, $attributes);
	}

	/**
	 * @param  string $name        The element name
	 * @param  string $value       The date displayed in this widget
	 * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
	 * @param  array  $errors      An array of errors for the field
	 *
	 * @return string An HTML tag string
	 *
	 * @see sfWidgetFormInput
	 */
	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		use_helper('Asset');
		$id= $this->generateId($name);
		$fn = uniqid("fn");
		if(!isset($attributes['size']) && !$this->getAttribute('size'))
		$attributes['size']=11;
		if($value!=NULL){
			$value = date($this->getOption('mascara'),DateUtils::_strtotime($value));
		}
		$tag =  $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value, 'onkeypress'=>"return soNums(event,this,'data');"), $attributes));
		$attrs = $this->getOption('img_attrs');
		$attrs['style']=isset($attrs['style'])?$attrs['style'].";":'cursor:pointer';
		$attrs['id']=$id . "_imgdatepicker";
		$attrs['type']="image";
		$attrs['onclick']="return false;";
		$width = isset($attrs['width'])?$attrs['width']:16;
		$height = isset($attrs['height'])?$attrs['height']:16;


		$image_tag="";
		if($this->getOption('image')!=NULL){
			$image_tag = $this->renderTag('input', array_merge(array('src'=>$this->getOption('image')),$attrs));
		}
		 
		$image_tag .=	sprintf(<<<EOF
				<script type="text/javascript">
						$(function() {
							$('#%s').datepick();
							$('#%s').datepick({onSelect:function(value){
								$('#%s').attr('value',value);
								}
							});																			
						})							
				</script>	
EOF
		,$id, $attrs['id'], $id);

		switch($this->getOption('img_position'))
		{
			case 'RIGHT':
				return  $tag . $image_tag;
				break;
			case 'TOP':
				return  $image_tag . "<br />" . $tag;
				break;
			case 'BOTTOM':
				return  $tag . "<br />" . $image_tag;
				break;
			case 'LEFT': default:
				return  $image_tag . $tag ;
		}

	}

	/**
	 * Gets the stylesheet paths associated with the widget.
	 *
	 * @return array An array of stylesheet paths
	 */
	public function getStylesheets()
	{
		return array('/sf/sf_default/css/calendar.css' => 'all');
	}

	/**
	 * Gets the JavaScript paths associated with the widget.
	 *
	 * @return array An array of JavaScript paths
	 */
	public function getJavascripts()
	{
		return array('/sf/sf_default/js/jquery.datepick.js','/sf/sf_default/js/jquery.datepick-'. $this->getOption('culture') .'.js','/sf/sf_default/js/jquery.datepick-validation.js');
	}
}
