<?php use_helper('i18n'); ?>
<div id="sf_admin_container">
<h1>Painel Gerenciador</h1>

<br /> 
<a href="<?php echo url_for('@admin_usuario')?>" class="lnkbtn">
	<?php echo image_tag('user_card.png'); ?>	
	<?php echo __('Usuários')?>
</a>

<a href="<?php echo url_for('@admin_grupo')?>" class="lnkbtn">
	<?php echo image_tag('department.png'); ?>	
	<?php echo __('Grupos')?>
</a>
 
<a href="<?php echo url_for('@admin_permissao')?>" class="lnkbtn">
	<?php echo image_tag('key.png'); ?>	
	<?php echo __('Permissões')?>
</a>

  
</div>